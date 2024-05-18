<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CollectionRate;
use App\Models\Collector;

class CollectionRateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CollectionRate::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'rate' => $this->faker->randomFloat(2, 0, 999999.99),
            'collector_id' => Collector::factory(),
        ];
    }
}
