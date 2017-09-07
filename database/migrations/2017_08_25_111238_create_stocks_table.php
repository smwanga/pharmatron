<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stock_code')->unique();
            $table->string('barcode')->nullable();
            $table->string('generic_name');
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('unit')->nullable();
            $table->text('description')->nullable();
            $table->integer('alert_level');
            $table->text('notes')->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
