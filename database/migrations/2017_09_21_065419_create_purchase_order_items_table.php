<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->double('qty')->nullable();
            $table->integer('invoice_id')->unsigned();
            $table->string('product_name')->nullable();
            $table->integer('pack_size')->nullable();
            $table->double('unit_cost')->nullable();
            $table->text('notes');
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_items');
    }
}
