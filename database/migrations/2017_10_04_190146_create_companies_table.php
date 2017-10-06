<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name', 255);
            $table->string('email', 64)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('phone_number', 64)->nullable();
            $table->string('address', 255)->nullable();
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

        Schema::table('people', function (Blueprint $table) {
            $table->integer('company_id')->nullable()->unsigned();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('CASCADE');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->integer('company_id')->nullable()->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('SET NULL');
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('company_id')->nullable()->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign('sales_company_id_foreign');
            $table->dropColumn(['company_id']);
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_company_id_foreign');
            $table->dropColumn(['company_id']);
        });

        Schema::table('people', function (Blueprint $table) {
            $table->dropForeign('people_company_id_foreign');
            $table->dropColumn(['company_id']);
        });

        Schema::dropIfExists('companies');
    }
}
