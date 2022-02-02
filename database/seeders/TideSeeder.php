<?php

namespace Database\Seeders;

use App\Models\Tide;

use Illuminate\Database\Seeder;

class TideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tide::factory()
        ->times(1)
        ->create();
    }
}
