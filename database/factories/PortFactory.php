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
        return [
            'identifier' => $this->faker->numberBetween(1, 20),
            'name' => $this->faker->city,
        ];
    }
}
