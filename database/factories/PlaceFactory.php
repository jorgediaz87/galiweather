<?php

namespace Database\Factories;

use App\Models\Port;
use App\Models\ReferencePort;
use App\Models\Place;

use Illuminate\Database\Eloquent\Factories\Factory;


class PlaceFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Place::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $portsIdentifiers = [1,2,4,6,7,8,9,10,11,12,13,14,15,16];
        $referencePortsIdentifiers = [1,2,3,4,10,14,15,16];

        return [
            'name' => $this->faker->city,
            'municipality' => $this->faker->city,
            'province' => $this->faker->randomElement(['A Coruña', 'Lugo', 'Ourense', 'Pontevedra']),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'port_id' => array_rand($portsIdentifiers, 1),
            // 'port_id' => Port::factory(), TODO: uncomment when found how to seed uniques
            'reference_port_id' => array_rand($referencePortsIdentifiers, 1),
            // 'reference_port_id' => ReferencePort::factory(), TODO: uncomment when found how to seed uniques
            'type' => $this->faker->randomElement(['beach', 'locality']),
        ];
    }
}
