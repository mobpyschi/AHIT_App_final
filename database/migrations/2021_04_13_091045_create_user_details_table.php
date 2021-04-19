<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('Email')->unique();
            $table->string('Sex')->nullable();
            $table->dateTime('Date_of_birth')->nullable();
            $table->dateTime('Work_start')->nullable();
            $table->dateTime('Work_end')->nullable();
            $table->string('Department')->nullable();
            $table->string('Role')->nullable();
            $table->string('Certificate')->nullable();
            $table->string('Address')->nullable();
            $table->string('Residence_Address')->nullable();
            $table->string('Phone')->nullable();
            $table->string('user_id');
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
        Schema::dropIfExists('user_details');
    }
}