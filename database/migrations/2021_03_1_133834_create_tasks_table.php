<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('details');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('status_id')->default(1);
            $table->bigInteger('assign')->unsigned(); //model_id of user
            $table->bigInteger('project_id')->unsigned()->index();
            $table->integer('progress')->default(0);
            $table->string('description')->nullable();
            $table->string('creator');
            $table->timestamps();

            $table->string('filesubmit')->nullable();
            $table->string('note')->nullable();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
