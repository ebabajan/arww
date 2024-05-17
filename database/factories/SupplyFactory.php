<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Supplier;
use App\Models\supply;

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
            'rate' => $this->faker->randomFloat(2, 0, 999999.99),
            'date_supplied' => $this->faker->dateTime(),
            'day_rate' => $this->faker->randomFloat(4, 0, 9999.9999),
            'supplier_id' =>  \App\Models\Supplier::factory(),
        ];
    }
}
