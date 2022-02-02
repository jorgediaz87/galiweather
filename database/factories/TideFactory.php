<?php

namespace Database\Factories;

use App\Models\TideForecast;

use Illuminate\Database\Eloquent\Factories\Factory;

class TideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tide_forecast_id' => TideForecast::factory(),
            'time_instant' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'state' => $this->faker->randomElement(
                [
                'High tides', 'Low tides'
                ]
            ),
            'height' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
