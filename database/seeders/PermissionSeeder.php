<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            'access users',
            'create users',
            'update users',
            'delete users',

            'access teachers',
            'create teachers',
            'edit teachers',
            'remove teachers',

            'access class',
            'create class',
            'edit class',
            'delete class',
            'generate paragraph',

            'access books',
            'create books',
            'edit books',
            'delete books',

            'access schedule',
            'create schedule',
            'edit schedule',
            'delete schedule',

            'access contracts',
            'create contract',
            'edit contract',
            'delete contract',
            'confirm payment',

            'access cashflow',

            'access entries',
            'create entries',
            'edit entries',
            'delete entries',

            'access categories',
            'create categories',
            'edit categories',
            'delete categories',

            'access origins',
            'create origins',
            'edit origins',
            'delete origins',

            'edit site info',

            'access students',
            'create students',
            'edit students',
            'delete students',

            'access roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }
    }
}
