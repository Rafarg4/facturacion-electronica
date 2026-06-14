<?php

namespace Database\Factories;

use App\Models\PresupuestoCabecera;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresupuestoCabeceraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PresupuestoCabecera::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cliente' => $this->faker->text,
        'estado' => $this->faker->text,
        'responsable' => $this->faker->text,
        'descripcion' => $this->faker->text,
        'sub_total' => $this->faker->text,
        'total' => $this->faker->text,
        'tipo_presupuesto' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
