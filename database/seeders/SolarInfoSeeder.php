<?php

namespace Database\Seeders;

use App\Models\SolarInfo;

use Illuminate\Database\Seeder;

class SolarInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SolarInfo::factory()
            ->times(24)
            ->forForecast([
                'place_id' => 1,
            ])
            ->create();
    }
}
