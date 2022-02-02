<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Wind;
use App\Models\Forecast;

class WindFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wind::class;

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
            'model_value' => $this->faker->randomFloat(2, 0, 100),
            'direction_value' => $this->faker->randomFloat(2, 0, 360),
        ];
    }
}
