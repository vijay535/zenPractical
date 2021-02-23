<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_detail', function (Blueprint $table) {
            $table->bigIncrements('invoiceDetail_id');
            $table->bigInteger('invoice_id');
            $table->bigInteger('product_id');
            $table->bigInteger('rate');
            $table->string('unit');
            $table->bigInteger('qty');
            $table->bigInteger('disc_percentage');
            $table->bigInteger('netAmount');
            $table->bigInteger('totalAmount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_detail');
    }
}
