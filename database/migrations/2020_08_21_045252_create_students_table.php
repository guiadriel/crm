<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->bigInteger('origin_id')->unsigned()->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->longText('observations')->nullable();
            $table->timestamps();

            $table->foreign('origin_id')->references('id')->on('origins')
                ->onDelete('set null')
                ->cascadeOnUpdate()
            ;
            $table->foreign('status_id')->references('id')->on('statuses')
                ->onDelete('set null')
                ->cascadeOnUpdate()
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
