<?php

use App\Models\Macro;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSeederResponsibleOnMacros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('macros', function (Blueprint $table) {
            //
        });

        $macros = [
            [ "group" => "Responsável", "name" => "ID", "macro" => '{$responsible.id}'],
            [ "group" => "Responsável", "name" => "Nome", "macro" => '{$responsible.name}'],
            [ "group" => "Responsável", "name" => "Gênero", "macro" => '{$responsible.gender}'],
            [ "group" => "Responsável", "name" => "Email", "macro" => '{$responsible.email}'],
            [ "group" => "Responsável", "name" => "Telefone", "macro" => '{$responsible.phone}'],
            [ "group" => "Responsável", "name" => "Dt. Nascimento", "macro" => '{$responsible.birthday_date}'],
            [ "group" => "Responsável", "name" => "RG", "macro" => '{$responsible.rg}'],
            [ "group" => "Responsável", "name" => "CPF", "macro" => '{$responsible.cpf}'],
            [ "group" => "Responsável", "name" => "CEP", "macro" => '{$responsible.zip_code}'],
            [ "group" => "Responsável", "name" => "Endereço", "macro" => '{$responsible.address}'],
            [ "group" => "Responsável", "name" => "Número", "macro" => '{$responsible.number}'],
            [ "group" => "Responsável", "name" => "Bairro", "macro" => '{$responsible.neighborhood}'],
            [ "group" => "Responsável", "name" => "Cidade", "macro" => '{$responsible.city}'],
            [ "group" => "Responsável", "name" => "Estado", "macro" => '{$responsible.state}'],
        ];

        Macro::insert($macros);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('macros', function (Blueprint $table) {
            //
        });
        DB::delete('delete from macros where macros.group = ?', ['Responsável']);
    }
}
