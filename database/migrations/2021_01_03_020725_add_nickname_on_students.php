<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNicknameOnStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            //
            $table->string('nickname')->after('name');
            $table->bigInteger('responsible_id')->unsigned()->nullable();

            $table->foreign('responsible_id')->references('id')->on('responsibles')
                ->onDelete('set null')
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            //
            $table->dropColumn('responsible_id');
            $table->dropColumn('nickname');
        });
    }
}
