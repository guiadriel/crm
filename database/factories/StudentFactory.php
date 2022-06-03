<?php

namespace Database\Factories;

use App\Models\Origin;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $origins;
    protected $status;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->origins = Origin::all()->pluck('id')->toArray();
        $this->status = Status::all()->pluck('id')->toArray();

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'phone_message' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['M', 'F']),
            'avatar' => 'http://localhost:8000/images/avatar.svg',
            'address' => $this->faker->streetName,
            'neighborhood' => 'Centro',
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'birthday_date' => $this->faker->date('d/m/Y'),
            'observations' => $this->faker->paragraph(),
            'status_id' => $this->faker->randomElement($this->status),
            'origin_id' => $this->faker->randomElement($this->origins),
        ];
    }
}
