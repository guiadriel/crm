<?php

namespace Database\Seeders;

use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class CreateSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        // $categories = [
//     ['name' => 'Administrador'],
//     ['name' => 'Recepção'],
//     ['name' => 'Financeiro'],
//     ['name' => 'Professor'],
//     ['name' => 'Aluno'],
        // ];

        $role = ModelsRole::create(['name' => Role::SUPER_ADMIN]);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
