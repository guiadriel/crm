<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartDateOnGroupclass extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('group_classes', function (Blueprint $table) {
            $table->date('start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('group_classes', function (Blueprint $table) {
            $table->dropColumn('start_date');
        });
    }
}
