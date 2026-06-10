<?php

namespace Database\Factories;

use App\Models\Tarifa;
use Illuminate\Database\Eloquent\Factories\Factory;

class TarifaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tarifa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo_plan' => $this->faker->text,
        'tarifa' => $this->faker->text,
        'descripcion' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
