<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockoutdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockoutdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_out_header_id');
            $table->integer('product_id')->nullable();
            $table->string('productname',150)->nullable();
            $table->integer('supplier_id')->nullable();
            $table->string('suppliername',30)->nullable();
            $table->integer('qty')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stockoutdetails');
    }
}
