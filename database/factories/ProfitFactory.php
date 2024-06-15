<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Collection;
use App\Models\Profit;

class ProfitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profit::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'rate_time' => $this->faker->dateTime(),
            'converted' => $this->faker->randomFloat(4, 0, .9999),
            'profit' => $this->faker->randomFloat(2, 0, 999999.99),
            'collection_id' => Collection::factory(),
        ];
    }
}
