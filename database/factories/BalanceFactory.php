<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Balance;
use App\Models\Supply;

class BalanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Balance::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'total_payable' => $this->faker->randomFloat(2, 0, 99999999.99),
            'amount_paid_1' => $this->faker->randomFloat(2, 0, 99999999.99),
            'amount_paid_2' => $this->faker->randomFloat(2, 0, 99999999.99),
            'amount_paid_3' => $this->faker->randomFloat(2, 0, 99999999.99),
            'amount_paid_4' => $this->faker->randomFloat(2, 0, 99999999.99),
            'amount_paid_5' => $this->faker->randomFloat(2, 0, 99999999.99),
            'remaining' => $this->faker->randomFloat(2, 0, 99999999.99),
            'supply_id' => Supply::factory(),
        ];
    }
}
