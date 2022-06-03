<?php

namespace Database\Seeders;

use App\Models\PaymentsMethod;
use App\Models\Status;
use Illuminate\Database\Seeder;

class PaymentsMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $status = Status::where('description', Status::STATUS_ATIVO)->first();

        $methods = [
            ['description' => 'BOLETO', 'status_id' => $status->id],
            ['description' => 'T. ITAU', 'status_id' => $status->id],
            ['description' => 'T. INTER', 'status_id' => $status->id],
        ];

        foreach ($methods as $method) {
            PaymentsMethod::create($method);
        }
    }
}
