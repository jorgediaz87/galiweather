<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\Forecast;

use Illuminate\Database\Seeder;


class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Place::factory()
            ->times(1)
            ->create();
    }
}
