<?php

namespace Database\Factories;

use App\Models\Port;

use Illuminate\Database\Eloquent\Factories\Factory;

class PortFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Port::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $portsIdentifiers = [1,2,4,6,7,8,9,10,11,12,13,14,15,16];

        return [
            'id' => $portsIdentifiers[array_rand($portsIdentifiers, 1)],
            'name' => $this->faker->city,
        ];
    }
}
