<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statusList = [
            ['description' => 'PROSPECTO'],
            ['description' => 'ATIVO'],
            ['description' => 'INATIVO'],
            ['description' => 'EM ATRASO'],
            ['description' => 'EM DIA'],
            ['description' => 'CANCELADO'],
            ['description' => 'PENDENTE'],
            ['description' => 'PAGO'],
            ['description' => 'REMARKETING'],
            ['description' => 'QUARENTENA'],
        ];
        foreach ($statusList as $status) {
            Status::create($status);
        }
    }
}
