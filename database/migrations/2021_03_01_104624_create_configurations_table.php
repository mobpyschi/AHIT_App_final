<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            // $table->string('name');
            $table->string('ipDefaut');
            // ipDefaut = '45.122.246.186'
            $table->time('timeStartCheckin');
            // timeStartCheckin = '08:00:00';
            $table->time('timeEndCheckin');
            // timeEndCheckin = '08:15:00';
            $table->time('timeStartCheckout');
            // timeStartCheckout = '16:50:00';
            $table->time('timeEndCheckout');
            // timeEndCheckout = '18:00:00';
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
        Schema::dropIfExists('configurations');
    }
}
