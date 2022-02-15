<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\ReferencePort;

class ReferencePortFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReferencePort::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $referencePortsIdentifiers = [1,2,3,4,10,14,15,16];

        return [
            'id' => $referencePortsIdentifiers[array_rand($referencePortsIdentifiers, 1)],
            'name' => $this->faker->city,
        ];
    }
}
