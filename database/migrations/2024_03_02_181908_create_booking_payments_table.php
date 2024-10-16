<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bookingId')->unsigned()->references('id')->on('bookings');
            $table->string('amount')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('paymentOption')->nullable();
            $table->string('currency')->nullable();
            $table->string('rate')->nullable();
            $table->string('actual_amount')->nullable();
            $table->foreignId('issuedBy')->unsigned()->references('id')->on('users');
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
        Schema::dropIfExists('booking_payments');
    }
}
