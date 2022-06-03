<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidAtOnContractPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_payments', function (Blueprint $table) {
            //
            $table->date('paid_at')->nullable()->after('bill_number');
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
            //
            $table->dropColumn('paid_at');
        });
    }
}

