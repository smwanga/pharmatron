<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->double('qty')->nullable();
            $table->integer('invoice_id')->unsigned();
            $table->integer('stock_id')->unsigned()->nullable();
            $table->double('unit_cost')->nullable();
            $table->text('instructions');
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('CASCADE');
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
