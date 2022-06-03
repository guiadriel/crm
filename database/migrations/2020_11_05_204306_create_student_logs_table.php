<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('student_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date_log')->nullable();
            $table->string('who_received')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('student_logs');
    }
}
