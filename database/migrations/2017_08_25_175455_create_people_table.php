<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('phone_number', 15)->nullable();
            $table->string('email', 65)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 65)->nullable();
            $table->string('role', 255);
            $table->string('img', 255)->nullable();
            $table->dateTime('date_employed')->nullable();
            $table->string('twitter_id', 255)->nullable();
            $table->string('instagram_id', 255)->nullable();
            $table->string('facebook_id', 255)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('status', 50);
            $table->integer('client_id')->nullable()->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('client_id')->references('id')->on('suppliers')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
