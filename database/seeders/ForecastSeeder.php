<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Forecast;

class ForecastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Forecast::factory()
            ->times(100)
            ->hasSkyState(240)
            ->create();
    }
}
