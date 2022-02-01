<?php

namespace Database\Seeders;

use App\Models\Temperature;

use Illuminate\Database\Seeder;

class TemperatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Temperature::factory()
            ->times(24)
            ->forForecast([
                'place_id' => 1,
            ])
            ->create();
    }
}
