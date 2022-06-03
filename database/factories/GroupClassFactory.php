<?php

namespace Database\Factories;

use App\Models\GroupClass;
use App\Models\Status;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupClass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $teacher = Teacher::all()->pluck('id')->toArray();
        $status = Status::all()->first();

        return [
            'name' => 'Turma'.$this->faker->firstName(),
            'number_vacancies' => rand(8, 10),
            'number_vacancies_demo' => rand(1, 3),
            'day_of_week' => rand(0, 6),
            'time_schedule' => $this->faker->time(),
            'type' => $this->faker->randomElement(['VIP', 'TURMA']),
            'status_id' => $status->id,
            'start_date' => $this->faker->date('d/m/Y'),
            'teacher_id' => $this->faker->randomElement($teacher),
        ];
    }
}
