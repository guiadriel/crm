<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPersonalFieldsOnTeachers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('teachers', function (Blueprint $table) {
            //
            $table->string('zip_code')->nullable();
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('rg')->nullable();
            $table->string('cpf')->nullable();
            $table->date('admission_date')->nullable();
            $table->date('resignation_date')->nullable();
            $table->string('bank_agency')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_type')->nullable();
            $table->string('bank_pix')->nullable();
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
            $table->dropColumn('zip_code');
            $table->dropColumn('address');
            $table->dropColumn('number');
            $table->dropColumn('neighborhood');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('rg');
            $table->dropColumn('cpf');
            $table->dropColumn('admission_date');
            $table->dropColumn('resignation_date');
            $table->dropColumn('bank_agency');
            $table->dropColumn('bank_account');
            $table->dropColumn('bank_type');
            $table->dropColumn('bank_pix');
        });
    }
}
