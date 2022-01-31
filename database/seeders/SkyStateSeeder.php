<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\SkyState;

class SkyStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SkyState::factory()
            ->times(100)
            ->create();
    }
}
