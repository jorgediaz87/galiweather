<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Forecast;
use App\Models\SolarInfo;

class SolarInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SolarInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'forecast_id' => Forecast::factory(),
            'sunrise' => $this->faker->time('H:i:s'),
            'midday' => $this->faker->time('H:i:s'),
            'sunset' => $this->faker->time('H:i:s'),
            'duration' => $this->faker->numberBetween(0, 24),
        ];
    }
}
