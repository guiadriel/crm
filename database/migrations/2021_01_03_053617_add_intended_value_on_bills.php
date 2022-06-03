<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntendedValueOnBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->decimal('intended_amount')->default(0);
            $table->boolean('has_installments')->default(0);
            $table->integer('sequence')->default(1);
            $table->unsignedBigInteger('referer_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('intended_amount');
            $table->dropColumn('sequence');
            $table->dropColumn('has_installments');
            $table->dropColumn('referer_id');
        });
    }
}
