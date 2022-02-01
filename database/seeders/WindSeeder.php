<?php

namespace Database\Seeders;

use App\Models\Wind;

use Illuminate\Database\Seeder;

class WindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wind::factory()
            ->times(24)
            ->forForecast([
                'place_id' => 1,
            ])
            ->create();
    }
}
