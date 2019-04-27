<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockoutheadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockoutheaders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default('0');
            $table->integer('admin_user_id')->default('0');
            $table->string('code','15')->nullable();
            $table->integer('total_qty')->default(0);
            $table->enum('status',['draft','posted','cancelled'])->default('draft');
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
        Schema::dropIfExists('stockoutheaders');
    }
}
