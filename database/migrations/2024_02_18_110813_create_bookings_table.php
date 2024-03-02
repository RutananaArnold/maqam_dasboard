<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->unsigned()->references('id')->on('users');
            $table->string('gender');
            $table->string('dob');
            $table->string('nationality');
            $table->string('residence');
            $table->string('passportPhoto');
            $table->foreignId('packageId')->unsigned()->references('id')->on('packages');
            $table->string('paymentOption')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
