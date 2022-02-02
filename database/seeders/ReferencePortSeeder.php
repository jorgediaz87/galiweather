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
                'identifier' => 1,
                'name' => 'A Coruña',
            ],
            [
                'identifier' => 2,
                'name' => 'Xixón',
            ],
            [
                'identifier' => 3,
                'name' => 'Vigo',
            ],
            [
                'identifier' => 4,
                'name' => 'Vilagarcía',
            ],
            [
                'identifier' => 10,
                'name' => 'A Guarda',
            ],
            [
                'identifier' => 14,
                'name' => 'Ferrol puerto exterior',
            ],
            [
                'identifier' => 15,
                'name' => 'Marín',
            ],
            [
                'identifier' => 16,
                'name' => 'Ferrol',
            ],
        ];

        foreach ($referencePorts as $referencePort) {
            ReferencePort::create($referencePort);
        }
    }
}
