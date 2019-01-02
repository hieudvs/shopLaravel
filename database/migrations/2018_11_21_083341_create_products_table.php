<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('id_type_item');
            $table->float('unit_price',20,2);
            $table->float('unit_purchase_price',20,2)->nullable();
            $table->float('promotion_price',20,2)->nullable();
            $table->string('unit');
            $table->string('qty_product')->nullable();
            $table->integer('id_producer')->nullable();
            $table->text('description')->nullable();
            $table->string('images');
            $table->integer('id_user')->nullable();
            $table->string('display_status')->nullable();
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
        Schema::dropIfExists('products');
    }
}
