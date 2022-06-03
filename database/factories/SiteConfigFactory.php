<?php

namespace Database\Factories;

use App\Models\SiteConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteConfigFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteConfig::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'address' => $this->faker->streetName,
            'number' => $this->faker->secondaryAddress,
            'district' => $this->faker->streetName,
            'city' => $this->faker->city,
            'state' => 'SP',
            'phone' => $this->faker->phoneNumber,
            'email' => 'company@email.com',
        ];
    }
}
