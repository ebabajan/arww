<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Collection;
use App\Models\Collector;
use App\Models\Supply;

class CollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Collection::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'amount_collected' => $this->faker->randomNumber(),
            'hawala_amount' => $this->faker->randomNumber(),
            'pickup_time' => $this->faker->dateTime(),
            'amount_to_pay' => $this->faker->randomFloat(2, 0, 99999999.99),
            'overheads' => $this->faker->randomFloat(2, 0, 999999.99),
            'supply_id' => Supply::factory(),
            'collector_id' => Collector::factory(),
        ];
    }
}
