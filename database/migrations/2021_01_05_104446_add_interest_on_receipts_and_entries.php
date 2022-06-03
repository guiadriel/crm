<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterestOnReceiptsAndEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->decimal('interest')->nullable()->default(0);
        });

        Schema::table('entries', function (Blueprint $table) {
            $table->decimal('interest')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('interest');
        });
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn('interest');
        });
    }
}
