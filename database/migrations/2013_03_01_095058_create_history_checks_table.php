<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_checks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('model_id');
            $table->time('checkin_time')->nullable();
            $table->time('checkout_time')->nullable();
            $table->time('OT_time')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();

            // $table->foreign('model_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_checks');
    }
}
