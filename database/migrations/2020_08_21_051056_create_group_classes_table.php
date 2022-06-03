<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupClassesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('group_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->integer('number_vacancies')->default(10);
            $table->integer('number_vacancies_demo')->default(3);
            $table->string('day_of_week')->nullable();
            $table->time('time_schedule');
            $table->bigInteger('teacher_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('group_classes');
    }
}
