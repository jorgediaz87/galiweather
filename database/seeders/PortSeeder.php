<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;

class PortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ports = [
            [
                'identifier' => 1,
                'name' => 'A Coruña',
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
                'identifier' => 6,
                'name' => 'Ría de Foz',
            ],
            [
                'identifier' => 7,
                'name' => 'Corcubión',
            ],
            [
                'identifier' => 8,
                'name' => 'Ría de Camariñas',
            ],
            [
                'identifier' => 9,
                'name' => 'Ría de Corme',
            ],
            [
                'identifier' => 10,
                'name' => 'A Guarda',
            ],
            [
                'identifier' => 11,
                'name' => 'A Guarda',
            ],
            [
                'identifier' => 12,
                'name' => 'Muros',
            ],
            [
                'identifier' => 13,
                'name' => 'Pontevedra',
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

        foreach ($ports as $port) {
            Port::create($port);
        }
    }
}
