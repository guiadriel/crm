<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\GroupClass;
use App\Models\SiteConfig;
use App\Models\Student;
use App\Models\Teacher;
use App\User;
use Database\Seeders\PlanoDeContasSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(StatusSeeder::class);
        $this->call(ConfigSeeder::class);

        $this->call(PermissionSeeder::class);
        $this->call(CreateSuperAdminSeeder::class);
        $this->call(PaymentsMethodSeeder::class);
        $this->call(PlanoDeContasSeeder::class);

        SiteConfig::factory()->count(1)->create();

        if (App::environment('local')) {
            $this->call(UserSeeder::class);
            // User::factory()->count(35)->create();

            $this->call(OriginSeeder::class);

            Teacher::factory()->count(10)->create();
            Student::factory()->count(200)->create();
            GroupClass::factory()->count(5)->create();


            $students = Student::all();

            GroupClass::All()->each(function ($groupClass) use ($students) {
                $groupClass->students()->attach(
                    $students->random(rand(1, 9))->pluck('id')->toArray()
                );
            });

            Contract::factory()->count(200)->create();


        }
    }
}
