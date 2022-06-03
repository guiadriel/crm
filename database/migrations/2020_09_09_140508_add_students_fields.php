<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentsFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->date('birthday_date')->nullable()->after('avatar');
            $table->string('rg')->nullable()->after('birthday_date');
            $table->string('cpf')->nullable()->after('rg');
            $table->string('endereco')->nullable()->after('cpf');
            $table->string('bairro')->nullable()->after('endereco');
            $table->string('cep')->nullable()->after('bairro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('birthday_date');
            $table->dropColumn('rg');
            $table->dropColumn('cpf');
            $table->dropColumn('endereco');
            $table->dropColumn('bairro');
            $table->dropColumn('cpf');
        });
    }
}
