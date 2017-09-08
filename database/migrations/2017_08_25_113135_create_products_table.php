<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_number');
            $table->string('lpo_number')->nullable();
            $table->text('description')->nullable();
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned();
            $table->integer('qty');
            $table->integer('pack_size');
            $table->integer('stock_available');
            $table->double('marked_price', 8, 4);
            $table->double('selling_price', 8, 4);
            $table->timestamp('expire_at')->nullable();
            $table->string('batch_no')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('SET NULL');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('SET NULL');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
