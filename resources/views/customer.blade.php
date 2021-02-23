<!DOCTYPE html>
<html lang="en">
<head>
  <title>Customer Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<div class="col-md-12">
	  <h3 style="text-align: center;">Customer Details</h3>
	  <hr/>
	  <form id="cform">
	  	@csrf
	    <div class="form-group col-md-6">
	      <label for="text">Customer Name:</label>
	      <input type="text" class="form-control" name="customerName">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="prod">Product:</label>
	      <select class="form-control" id="product_id" name="productName">
	      	<option>Select Product</option>
	      	@foreach($product as $productRow)
	      	<option value="{{ $productRow->product_id }}">{{ $productRow->product_name }}</option>
	      	@endforeach
	      </select>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="rate">Rate:</label>
	      <input type="text" class="form-control" id="rate" name="productRate" readonly>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="unit">Unit:</label>
	      <input type="text" class="form-control" id="unit" name="productUnit" readonly>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="qty">Qty:</label>
	      <input type="text" class="form-control" id="qty" name="quantity">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="dis">Discount (%):</label>
	      <input type="text" class="form-control" id="dis" name="discount">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="na">Net Amount:</label>
	      <input type="text" class="form-control" id="netamt" name="netAmount" readonly>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="ta">Total Amount:</label>
	      <input type="text" class="form-control" id="totalamt" name="totalAmount" readonly>
	    </div>
	   
	    <button type="submit" class="btn btn-success" style="margin-bottom: 16px;">+ADD</button>
	  </form>

	  <!-- Grid View Form -->
	  <form method="post" action="product">
	  	@csrf
		  <table class="table table-bordered" id="addmorefields">
		  	<thead>
		      <tr>
		        <th>Product</th>
		        <th>Rate</th>
		        <th>Unit</th>
		        <th>Qty</th>
		        <th>Disc%</th>
		        <th>Net Amt.</th>
		        <th>Total Amt.</th>
		      </tr>
		    </thead>
		    <tbody>
		      <tr>
		        <td>
		        	<input type="hidden" name="custname">
		        	<select name="product" class="form-control" id="pname">
			        	<option value="">Select Product</option>
				      	@foreach($product as $productRow)
				      	<option value="{{ $productRow->product_id }}">{{ $productRow->product_name }}</option>
				      	@endforeach
			        </select>
		        </td>
		        <td>
		        	<input type="text" name="rate" id="prate" readonly class="form-control">
		        	@if($errors->has('rate'))
					    <div class="error">{{ $errors->first('rate') }}</div>
					@endif

		        </td>
		        <td><input type="text" name="unit" id="punit" readonly class="form-control"></td>
		        <td><input type="text" name="qty" id="pqty" class="form-control"></td>
		        <td><input type="text" name="disc" id="pdis" class="form-control"></td>
		        <td><input type="text" name="netamt" id="pnetamt" readonly class="form-control"></td>
		        <td><input type="text" name="totalamt" id="ptotalamt" readonly class="form-control"></td>
		      </tr>
		      <tr>
		      	<td colspan="8">
		      		@if ($message = Session::get('success'))
				        <div class="alert alert-success">
				            <p>{{ $message }}</p>
				        </div>
			     	@endif
		      		<button type="submit" class="btn btn-primary" name="submit" style="float: right;    width: 150px;">Submit</button>
		      	</td>
		      </tr>
		    </tbody>
		  </table>
		  
	  </form>

    </div>
</div>

<script type="text/javascript">
	$('#product_id').on('change', function(){
		var pid = $(this).val();
		$.ajax({
            type:"GET",
            url:"{{url('productRateUnit')}}?productID="+pid,
            success:function(res){               
	            if(res){
	                $.each(res,function(key,value){
	                    $("#rate").val(value['rate']);
	                    $("#unit").val(value['unit']);
	                });
	            }else{
	               $("#rate").empty();
	               $("#unit").empty();
	            }
            }
        });
	});

	$('#pname').on('change', function(){
		var pid = $(this).val();
		//alert(pid);
		$.ajax({
            type:"GET",
            url:"{{url('productRateUnit')}}?productID="+pid,
            success:function(res){               
	            if(res){
	                $.each(res,function(key,value){
	                    $("#prate").val(value['rate']);
	                    $("#punit").val(value['unit']);
	                });
	            }else{
	               $("#rate").empty();
	               $("#unit").empty();
	            }
            }
        });
	});

//FORM DATA ADD IN GRID VIEW
	$('#cform').submit(function(e) { 
        e.preventDefault();
		$.ajax({
            type: 'POST',
            url: '{{url("custAddProduct")}}',
            data: $(this).serialize(),
            dataType: 'json',
            encode: true,
            success:function(data){  
            	console.log(data); 
            	$("#cform")[0].reset(); 
            	$('input[name ="custname"]').val(data['customerName']);            
	            $('#pname').val(data['productsID']); 
	            $('input[name ="rate"]').val(data['productRate']); 
	            $('input[name ="unit"]').val(data['productUnit']); 
	            $('input[name ="qty"]').val(data['quantity']); 
	            $('input[name ="disc"]').val(data['discount']); 
	            $('input[name ="netamt"]').val(data['netAmount']); 
	            $('input[name ="totalamt"]').val(data['totalAmount']); 
            }
        });
	});

	//Calculation
	$(document).on("change keyup blur", "#dis,#qty", function() {
        var rate = $('#rate').val();
        var qty = $('#qty').val();
	    var disc = $('#dis').val();
		
        var dec = (disc / 100).toFixed(2); 
		var totalrate = rate*qty;
		console.log("Qty Amt", totalrate);
        var desamt = totalrate * dec; 
		console.log("Dis Amt", desamt);
        var discont = totalrate - desamt;
        if (desamt == 0) {
        	$('#netamt').val(totalrate);
        	$('#totalamt').val(totalrate);
        }else{
        	$('#netamt').val(discont);
        	$('#totalamt').val(discont);
        }
        
    });
    //Grid View Calculation
    $(document).on("change keyup blur", "#pdis,#pqty,#pname", function() {
        var rate = $('#prate').val();
        var qty = $('#pqty').val();
	    var disc = $('#pdis').val();
		
        var dec = (disc / 100).toFixed(2); 
		var totalrate = rate*qty;
		console.log("Qty Amt", totalrate);
        var desamt = totalrate * dec; 
		console.log("Dis Amt", desamt);
        var discont = totalrate - desamt;
        if (desamt == 0) {
        	$('#pnetamt').val(totalrate);
        	$('#ptotalamt').val(totalrate);
        }else{
        	$('#pnetamt').val(discont);
        	$('#ptotalamt').val(discont);
        }
        
    });
</script>

</body>
</html>
