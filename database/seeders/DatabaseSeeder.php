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
        ]);

        Collector::factory()->create([
            'name' => "Premier x",
        ]);

        Collector::factory()->create([
            'name' => "Shpun",
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
