<?php

use App\Models\Macro;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMacrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('macros', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('macro')->nullable()->index();
            $table->string('group')->nullable();
            $table->timestamps();
        });

        $macros = [
            [ "group" => "Aluno", "name" => "ID", "macro" => '{$student.id}'],
            [ "group" => "Aluno", "name" => "Nome", "macro" => '{$student.name}'],
            [ "group" => "Aluno", "name" => "Gênero", "macro" => '{$student.gender}'],
            [ "group" => "Aluno", "name" => "Email", "macro" => '{$student.email}'],
            [ "group" => "Aluno", "name" => "Telefone", "macro" => '{$student.phone}'],
            [ "group" => "Aluno", "name" => "Telefone (Recado)", "macro" => '{$student.phone_message}'],
            [ "group" => "Aluno", "name" => "Dt. Nascimento", "macro" => '{$student.birthday_date}'],
            [ "group" => "Aluno", "name" => "RG", "macro" => '{$student.rg}'],
            [ "group" => "Aluno", "name" => "CPF", "macro" => '{$student.cpf}'],
            [ "group" => "Aluno", "name" => "CEP", "macro" => '{$student.zip_code}'],
            [ "group" => "Aluno", "name" => "Endereço", "macro" => '{$student.address}'],
            [ "group" => "Aluno", "name" => "Número", "macro" => '{$student.number}'],
            [ "group" => "Aluno", "name" => "Bairro", "macro" => '{$student.neighborhood}'],
            [ "group" => "Aluno", "name" => "Cidade", "macro" => '{$student.city}'],
            [ "group" => "Aluno", "name" => "Estado", "macro" => '{$student.state}'],

            [ "group" => "Contrato", "name" => "ID do contrato", "macro" =>'{$contract.id}'],
            [ "group" => "Contrato", "name" => "Número", "macro" =>'{$contract.number}'],
            [ "group" => "Contrato", "name" => "Tipo", "macro" =>'{$contract.type}'],
            [ "group" => "Contrato", "name" => "Data inicial", "macro" =>'{$contract.start_date}'],
            [ "group" => "Contrato", "name" => "Dia vencimento", "macro" =>'{$contract.payment_due_date}'],
            [ "group" => "Contrato", "name" => "Valor mensal", "macro" =>'{$contract.payment_monthly_value}'],
            [ "group" => "Contrato", "name" => "Valor matrícula", "macro" =>'{$contract.payment_registration_value}'],
            [ "group" => "Contrato", "name" => "Quantidade de parcelas", "macro" =>'{$contract.payment_quantity}'],
            [ "group" => "Contrato", "name" => "Valor total", "macro" =>'{$contract.payment_total}'],

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
        Schema::dropIfExists('macros');
    }
}
