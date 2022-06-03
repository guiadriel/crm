<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillCodeOnPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_payments', function (Blueprint $table) {
            $table->string('bill_bank_code')->nullable()->after('bill_number');
            $table->boolean('bill_second_generation')->default(0)->after('bill_bank_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_payments', function (Blueprint $table) {
            $table->dropColumn('bill_bank_code');
            $table->dropColumn('bill_second_generation');
        });
    }
}
