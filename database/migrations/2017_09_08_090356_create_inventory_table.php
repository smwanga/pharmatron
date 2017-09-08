<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qty');
            $table->integer('on_stock');
            $table->string('comment')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->string('tr_type')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL');
        });
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_number');
            $table->string('customer_name');
            $table->double('amount', 6, 4)->nullable();
            $table->double('discount', 6, 4)->nullable();
            $table->double('tax', 6, 4)->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL');
        });
        Schema::create('sale_items', function (Blueprint $table) {
            $table->increments('id');
            $table->double('qty')->nullable();
            $table->integer('sale_id')->unsigned();
            $table->integer('product_id')->unsigned()->nullable();
            $table->double('unit_cost', 6, 4)->nullable();
            $table->text('instructions');
            $table->timestamps();

            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('CASCADE');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('inventory');
    }
}
