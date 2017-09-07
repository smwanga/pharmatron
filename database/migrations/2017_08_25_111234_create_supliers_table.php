<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupliersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        /*
           * Migration schema for table config
           *
        */
        Schema::create('app_configs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('key', 255);
            $table->text('value');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        /*
            * Migration schema for table categories
            *
        */
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category', 25);
            $table->string('group', 25);
            $table->text('description');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        /*
            * Migration schema for table currencies
            *
        */
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title', 255);
            $table->string('symbol_left', 12)->nullable();
            $table->string('symbol_right', 12)->nullable();
            $table->string('code', 3);
            $table->integer('decimal_place')->nullable();
            $table->double('value');
            $table->string('decimal_point', 3)->nullable();
            $table->string('thousand_point', 3)->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplier_name', 255);
            $table->integer('primary_contact')->nullable()->unsigned();
            $table->string('supplier_email', 64)->nullable();
            $table->string('supplier_website', 255)->nullable();
            $table->string('supplier_phone', 64)->nullable();
            $table->string('supplier_address', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 255)->nullable();
            $table->integer('currency_id')->nullable()->unsigned();
            $table->string('country', 255)->nullable();
            $table->string('VAT', 64)->nullable();
            $table->string('zip', 20)->nullable();
            $table->mediumText('notes')->nullable();
            $table->string('logo', 255)->nullable();
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('SET NULL');
        });
    }

    /***
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('app_configs');
    }
}
