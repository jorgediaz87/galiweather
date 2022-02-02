<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\TideForecast;
use App\Models\Place;

class TideForecastFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TideForecast::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'place_id' => Place::factory(),
            'begin_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}
