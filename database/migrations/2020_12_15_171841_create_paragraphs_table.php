<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParagraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paragraphs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_classes_id');
            $table->date('date')->index();
            $table->string('page');
            $table->string('last_word');
            $table->unsignedBigInteger('book_id')->nullable();
            $table->string('activity')->nullable();
            $table->string('observation')->nullable();
            $table->unsignedBigInteger('teacher_id');
            $table->softDeletes();
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
        Schema::dropIfExists('paragraphs');
    }
}
