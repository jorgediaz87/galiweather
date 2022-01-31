<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Place;

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
            'type' => $this->faker->randomElement(['beach', 'locality']),
        ];
    }
}
