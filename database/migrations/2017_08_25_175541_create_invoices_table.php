<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('reference_no', 32)->nullable();
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->timestamp('due_after')->nullable();
            $table->text('notes')->nullable();
            $table->double('tax', 4, 2);
            $table->double('discount', 4, 2);
            $table->boolean('recurring');
            $table->string('r_freq', 10)->default('monthly');
            $table->timestamp('recur_start_date')->nullable();
            $table->timestamp('recur_end_date')->nullable();
            $table->string('recur_frequency', 12)->nullable();
            $table->timestamp('recur_next_date')->nullable();
            $table->integer('currency_id')->nullable()->unsigned();
            $table->string('status', 12)->default('Unpaid');
            $table->text('share_token')->nullable();
            $table->boolean('archived')->nullable();
            $table->timestamp('date_sent')->nullable();
            $table->boolean('emailed')->default(false);
            $table->boolean('show_client')->default(false);
            $table->boolean('viewed')->default(false);
            $table->integer('alert_overdue')->nullable();
            $table->double('extra_fee')->nullable();
            $table->string('type', 255)->default('invoice');
            $table->string('invoiced', 255)->nullable();
            $table->integer('created_by')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('SET NULL');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
