<?php

namespace Database\Factories;

use App\Models\Electrodomestico;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElectrodomesticoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Electrodomestico::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->text,
        'marca' => $this->faker->text,
        'precio' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
