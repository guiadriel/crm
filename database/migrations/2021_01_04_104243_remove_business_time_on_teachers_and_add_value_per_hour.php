<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveBusinessTimeOnTeachersAndAddValuePerHour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            //
            $table->dropColumn('schedule_initial');
            $table->dropColumn('schedule_final');
            $table->decimal('value_per_class')->nullable()->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('value_per_class');
            $table->time('schedule_initial')->nullable();
            $table->time('schedule_final')->nullable();
        });
    }
}
