<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::create(
            [
                'name' => 'Guilherme Adriel da Rocha',
                'email' => 'gui.adriel@gmail.com',
                'password' => Hash::make('guilherme1'),
            ]
        );

        $user->roles()->sync([1]);
    }
}
