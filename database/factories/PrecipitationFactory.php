<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Forecast;

class PrecipitationFactory extends Factory
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
                'model_run_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
                'value' => $this->faker->numberBetween(0, 100),
            ];
    }
}
