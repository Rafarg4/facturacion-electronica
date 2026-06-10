<?php

namespace Database\Factories;

use App\Models\Seguro;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeguroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Seguro::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'estado_civil' => $this->faker->text,
        'edad' => $this->faker->text,
        'usted_es' => $this->faker->text,
        'padece_enfermedad' => $this->faker->text,
        'especificar_enfermedad' => $this->faker->text,
        'presenta_defecto_fisico' => $this->faker->text,
        'especifique_defecto_fisico' => $this->faker->text,
        'estatura' => $this->faker->text,
        'peso' => $this->faker->text,
        'plan' => $this->faker->text,
        'nombre_apellido_fallecimiento_titular' => $this->faker->text,
        'parentesco_titular_beneficiario' => $this->faker->text,
        'ci_beneficiario' => $this->faker->text,
        'porcentaje_cesion' => $this->faker->text,
        'fechanac_beneficiario' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
