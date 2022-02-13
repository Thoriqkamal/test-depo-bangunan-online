<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbStockProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_stock_product', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('stock_product');
            $table->string('stock_number');
            $table->string('stock_type');
            $table->string('stock_description');
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
        Schema::dropIfExists('tb_stock_product');
    }
}
