<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSondaMpolasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sonda_mpolas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('identificationType')->nullable();
            $table->string('nin_or_passport')->nullable();
            $table->string('dateOfExpiry')->nullable();
            $table->string('phone')->nullable();
            $table->string('otherPhone')->nullable();
            $table->string('email')->nullable();
            $table->string('savingFor')->nullable();
            $table->string('umrahSavingTarget')->nullable();
            $table->string('hajjSavingTarget')->nullable();
            $table->string('targetAmount')->nullable();
            $table->string('gender')->nullable();
            $table->string('occupation')->nullable();
            $table->string('position')->nullable();
            $table->string('dob')->nullable();
            $table->string('placeOfBirth')->nullable();
            $table->string('fatherName')->nullable();
            $table->string('motherName')->nullable();
            $table->string('maritalStatus')->nullable();
            $table->string('country')->nullable();
            $table->string('nationality')->nullable();
            $table->string('residence')->nullable();
            $table->string('district')->nullable();
            $table->string('county')->nullable();
            $table->string('subcounty')->nullable();
            $table->string('parish')->nullable();
            $table->string('village')->nullable();
            $table->string('nextOfKin')->nullable();
            $table->string('relationship')->nullable();
            $table->string('nextOfKinAddress')->nullable();
            $table->string('mobileNo')->nullable();
            $table->string('image')->nullable();
            $table->string('reference')->nullable();
            $table->string('process_status')->nullable();
            $table->foreignId('created_by')->unsigned()->references('id')->on('users');
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
        Schema::dropIfExists('sonda_mpolas');
    }
}
