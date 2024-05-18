<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Collector;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Ehsan',
            'email' => 'test@example.com',

        ]);

        Collector::factory()->create([
            'name' => "For Secure",
            'rate' => 1.15,
        ]);

        Collector::factory()->create([
            'name' => "Premier x",
            'rate' => 1.20
        ]);

        Collector::factory()->create([
            'name' => "Shpun",
            'rate' => 1.25
        ]);

        Branch::factory()->create([
            'name' => 'PKM',
            'location' => 'Peckham'
        ]);

        Branch::factory()->create([
            'name' => 'CDL',
            'location' => 'Collindale'
        ]);
    }
}
