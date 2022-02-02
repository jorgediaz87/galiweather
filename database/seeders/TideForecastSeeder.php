<?php

namespace Database\Seeders;

use App\Models\TideForecast;

use Illuminate\Database\Seeder;

class TideForecastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TideForecast::factory()
            ->times(1)
            ->create();
    }
}
