<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $configParameters = [
            [
                'key' => Config::CFG_CONTRACT_COUNT,
                'value' => 0,
            ],
        ];

        foreach ($configParameters as $config) {
            Config::create($config);
        }
    }
}
