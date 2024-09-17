<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSondaMpolaPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sonda_mpola_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sondaMpolaId')->unsigned()->references('id')->on('sonda_mpolas');
            $table->string('amount')->nullable();
            $table->string('payment_option')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('currency')->nullable();
            $table->string('rate')->nullable();
            $table->string('actual_amount')->nullable();
            $table->string('balance')->nullable();
            $table->string('target_amount_status')->nullable();
            $table->foreignId('receipted_by')->unsigned()->references('id')->on('users');
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
        Schema::dropIfExists('sonda_mpola_payments');
    }
}
