<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    public function index(){
    	$product = Customer::all();
    	return view('customer', compact('product'));
    }

    public function getProductRate(Request $request){
    	$prodRateUnit = DB::table("product_master")
        ->where("product_id", $request->productID)
        ->select("rate","unit")->get()->toArray();
        return response()->json($prodRateUnit);
    }

    public function getCustomerData(Request $request)
    {
    	$customer = array(
			'customerName' => $request->input('customerName'),
			'productsID' => $request->input('productName'),
			'productRate' => $request->input('productRate'),
			'productUnit' => $request->input('productUnit'),
			'quantity' => $request->input('quantity'),
			'discount' => $request->input('discount'),
			'netAmount' => $request->input('netAmount'),
			'totalAmount' => $request->input('totalAmount'),
    	);
    	return response()->json($customer);
    }

    public function store(Request $request)
    {
    	if (isset($_POST['submit'])) {	
	    	$request->validate([
	            'product' => 'required',
	            'rate' => 'required',
	            'unit' => 'required',
	            'qty' => 'required',
	            'disc' => 'required',
	            'netamt' => 'required',
	            'totalamt' => 'required',
	        ]);
	    	$invoiceNo = rand();
	        $invoiceMaster = array(
	        	'invoice_no'=>$invoiceNo,
	        	'invoice_date' => date('d/m/Y'),
	        	'customerName' => $request->input('custname'),
	       		'totalAmount' => $request->input('totalamt'),
	        );

	    	DB::table('invoice_master')->insert($invoiceMaster);
	        $sql = "select `invoice_id` from invoice_master ORDER BY `invoice_id` DESC LIMIT 1";
            $invoiceid = DB::select($sql);
            foreach ($invoiceid as $invoiceidval) {
            	$invoiceid = $invoiceidval->invoice_id;
            }
            
			$invoiceDetails = array(
				'invoice_id' => $invoiceid,
				'product_id' => $request->input('product'),
				'rate' => $request->input('rate'),
				'unit' => $request->input('unit'),
				'qty' => $request->input('qty'),
				'disc_percentage' => $request->input('disc'),
				'netAmount' => $request->input('netamt'),
				'totalAmount' => $request->input('totalamt'),
			);
			//dd($invoiceDetails);
			DB::table('invoice_detail')->insert($invoiceDetails);
			return back()->with('success', 'Record Added successfully.');
			
    	}
    }

}
