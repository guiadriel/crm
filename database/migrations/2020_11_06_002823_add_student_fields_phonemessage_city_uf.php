<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentFieldsPhonemessageCityUf extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('endereco');
            $table->dropColumn('bairro');
            $table->dropColumn('cep');

            $table->string('phone_message')->nullable()->after('phone');
            $table->string('gender')->nullable()->after('name');
            $table->string('zip_code')->nullable()->after('cpf');
            $table->string('address')->nullable()->after('zip_code');
            $table->string('number')->nullable()->after('address');
            $table->string('neighborhood')->nullable()->after('number');
            $table->string('city')->nullable()->after('neighborhood');
            $table->string('state')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->removeColumn('phone_message');
            $table->removeColumn('gender');
            $table->removeColumn('zip_code');
            $table->removeColumn('address');
            $table->removeColumn('number');
            $table->removeColumn('neighborhood');
            $table->removeColumn('city');
            $table->removeColumn('state');
        });
    }
}
