<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillNumber extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('contract_payments', function (Blueprint $table) {
            $table->string('bill_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('contract_payments', function (Blueprint $table) {
            $table->dropColumn('bill_number');
        });
    }
}
