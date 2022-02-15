<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReferencePort;

class ReferencePortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $referencePorts = [
            [
                'id' => 1,
                'name' => 'A Coruña',
            ],
            [
                'id' => 2,
                'name' => 'Xixón',
            ],
            [
                'id' => 3,
                'name' => 'Vigo',
            ],
            [
                'id' => 4,
                'name' => 'Vilagarcía',
            ],
            [
                'id' => 10,
                'name' => 'A Guarda',
            ],
            [
                'id' => 14,
                'name' => 'Ferrol puerto exterior',
            ],
            [
                'id' => 15,
                'name' => 'Marín',
            ],
            [
                'id' => 16,
                'name' => 'Ferrol',
            ],
        ];

        foreach ($referencePorts as $referencePort) {
            ReferencePort::create($referencePort);
        }
    }
}
