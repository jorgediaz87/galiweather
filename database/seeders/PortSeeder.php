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
                'id' => 1,
                'name' => 'A Coruña',
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
                'id' => 6,
                'name' => 'Ría de Foz',
            ],
            [
                'id' => 7,
                'name' => 'Corcubión',
            ],
            [
                'id' => 8,
                'name' => 'Ría de Camariñas',
            ],
            [
                'id' => 9,
                'name' => 'Ría de Corme',
            ],
            [
                'id' => 10,
                'name' => 'A Guarda',
            ],
            [
                'id' => 11,
                'name' => 'Ribeira',
            ],
            [
                'id' => 12,
                'name' => 'Muros',
            ],
            [
                'id' => 13,
                'name' => 'Pontevedra',
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

        foreach ($ports as $port) {
            Port::create($port);
        }
    }
}
