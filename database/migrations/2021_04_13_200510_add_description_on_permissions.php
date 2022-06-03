<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class AddDescriptionOnPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('description')->after('name')->nullable();
        });

        $permissions = [
            'access users' => 'acessar usuários',
            'create users' => 'criar usuários',
            'update users' => 'editar usuários',
            'delete users' => 'remover usuarios',
            'access teachers' => 'acessar professores',
            'create teachers' => 'criar professores',
            'edit teachers' => 'editar professores',
            'remove teachers' => 'acessar professores',
            'access class' => 'acessar turmas',
            'create class' => 'criar turmas',
            'edit class' => 'editar turmas',
            'delete class' => 'remover turmas',
            'generate paragraph' => 'gerar arquivo de parágrafo',
            'access books' => 'acessar books',
            'create books' => 'criar books',
            'edit books' => 'editar books',
            'delete books' => 'remover books',
            'access schedule' => 'acessar agendamentos',
            'create schedule' => 'criar agendamentos',
            'edit schedule' => 'editar agendamentos',
            'delete schedule' => 'remover agendamentos',
            'access contracts' => 'acessar contrato',
            'create contract' => 'criar contrato',
            'edit contract' => 'editar contrato',
            'delete contract' => 'remover contrato',
            'confirm payment' => 'confirmar pagamento',
            'access cashflow' => 'acessar visão geral',
            'access entries' => 'acessar movimento de caixa',
            'create entries' => 'criar movimento de caixa',
            'edit entries' => 'editar movimento de caixa',
            'delete entries' => 'remover movimento de caixa',
            'access categories' => 'acessar categorias',
            'create categories' => 'criar categorias',
            'edit categories' => 'editar categorias',
            'delete categories' => 'remover categorias',
            'access origins' => 'acessar origens',
            'create origins' => 'criar origens',
            'edit origins' => 'editar origens',
            'delete origins' => 'remover origens',
            'edit site info' => 'editar informações do site',
            'access students' => 'acessar alunos',
            'create students' => 'criar alunos',
            'edit students' => 'editar alunos',
            'delete students' => 'remover alunos',
            'access roles' => 'acessar funções do sistema',
            'create roles' => 'criar funções do sistema',
            'edit roles' => 'editar funções do sistema',
            'delete roles' => 'remover funções do sistema',
            'access files' => 'acessar arquivos',
            'upload files' => 'subir arquivos no sistema',
            'delete files' => 'remover arquivos',
        ];

        foreach( $permissions as $permission => $description)
        {
            Permission::where('name', $permission)
            ->update([
                'description' => $description
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
