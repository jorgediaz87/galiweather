<?php

namespace Database\Seeders;

use App\Models\Precipitation;

use Illuminate\Database\Seeder;


class PrecipitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Precipitation::factory()
            ->times(24)
            ->forForecast([
                'place_id' => 1,
            ])
            ->create();

    }
}
