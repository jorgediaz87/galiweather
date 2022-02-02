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

        return [
            'name' => $this->faker->city,
            'municipality' => $this->faker->city,
            'province' => $this->faker->randomElement(['A Coruña', 'Lugo', 'Ourense', 'Pontevedra']),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            // 'port_id' => $portsIdentifiers[array_rand($portsIdentifiers, 1)],
            'port_id' => Port::factory(),
            'reference_port_id' => ReferencePort::factory(),
            'type' => $this->faker->randomElement(['beach', 'locality']),
        ];
    }
}
