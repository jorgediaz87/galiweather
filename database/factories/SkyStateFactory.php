<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkyStateFactory extends Factory
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
            'value' => $this->faker->randomElement(
                [
                'SUNNY', 'HIGH_CLOUDS,', 'PARTLY_CLOUDY,',
                'OVERCAST', 'CLOUDY', 'FOG', 'SHOWERS',
                'OVERCAST_AND_SHOWERS', 'INTERMITENT_SNOW','INTERMITENT_SNOW',
                'RAIN','SNOW','STORMS','MIST','FOG_BANK','MID_CLOUDS',
                'WEAK_RAIN','WEAK_SHOWERS','STORM_THEN_CLOUDY','MELTED_SNOW'
                ]
            )
        ];
    }
}
