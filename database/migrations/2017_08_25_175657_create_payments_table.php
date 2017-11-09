<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('person_name')->nullable();
            $table->double('amount');
            $table->string('mode');
            $table->string('tr_code', 255);
            $table->integer('authorized_by')->nullable()->unsigned();
            $table->integer('invoice_id')->nullable()->unsigned();
            $table->integer('sale_id')->nullable()->unsigned();
            $table->string('status', 255)->default('Payment');
            $table->text('notes');
            $table->integer('currency_id')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('SET NULL');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('SET NULL');
            $table->foreign('authorized_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL');
        });
        /*
            * Migration schema for table expenses
            *
        */
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('type', 255)->nullable();
            $table->double('amount');
            $table->text('description');
            $table->integer('added_by')->nullable()->unsigned();
            $table->string('status', 25);
            $table->integer('approved_by')->unsigned()->nullable();
            $table->integer('currency_id')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('payments');
    }
}
