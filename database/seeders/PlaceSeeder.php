<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Place;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Place::factories()
            ->times(50)
            ->hasForecast(10)
            ->create();
    }
}
