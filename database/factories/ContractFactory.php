<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\GroupClass;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    protected $order = 1;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = Status::where('description', Status::STATUS_ATIVO)->first();
        $students = Student::all()->pluck('id')->toArray();
        $groupClass = GroupClass::all()->pluck('id')->toArray();

        $randomType = $this->faker->randomElement(['VIP', rand(1, 2).'X']);
        $type = ('VIP' === $randomType) ? 'VIP' : 'NORMAL';

        $randomNumber = $randomType.str_pad($this->order++, 4, 0, STR_PAD_LEFT);

        $quantityPayment = rand(1, 6);

        return [
            'number' => $randomNumber,
            'type' => $type,
            'start_date' => $this->faker->date('d/m/Y'),
            'payment_due_date' => rand(1, 31),
            'payment_monthly_value' => 150.00,
            'payment_total' => 1200.00,
            'payment_quantity' => $quantityPayment,
            'payment_registration_value' => 50.00,
            'student_id' => $this->faker->randomElement($students),
            'group_classes_id' => $this->faker->randomElement($groupClass),
            'status_id' => $status->id,
        ];
    }
}
