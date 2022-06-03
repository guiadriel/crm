<?php

namespace Database\Seeders;

use App\Models\Origin;
use Illuminate\Database\Seeder;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['type' => 'Indicação'],
            ['type' => 'Facebook'],
            ['type' => 'Instagram'],
            ['type' => 'Poiema'],
            ['type' => 'Youtube'],
            ['type' => 'Porta Frente'],
        ];

        foreach ($categories as $category) {
            Origin::create($category);
        }
    }
}
