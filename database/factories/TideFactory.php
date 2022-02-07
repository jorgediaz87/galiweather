<?php

namespace Database\Factories;

use App\Models\Forecast;

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
            'forecast_id' => Forecast::factory(),
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
