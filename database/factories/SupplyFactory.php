<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Supplier;
use App\Models\Supply;

class SupplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supply::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomNumber(),
            'ex_rate' => $this->faker->randomFloat(4, 0, .9999),
            'date_supplied' => $this->faker->dateTime(),
            'total_payable' => $this->faker->randomFloat(2, 0, 99999999.99),
            'supplier_id' => Supplier::factory(),
        ];
    }
}
