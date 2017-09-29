<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountToStock extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->float('discount')->nullable();
            $table->float('buying_price')->nullable();
            $table->timestamp('invoiced_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['discount', 'buying_price', 'invoiced_at']);
        });
    }
}
