<?php

namespace Database\Factories;

use App\Models\Inscripcion;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscripcionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inscripcion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'primer_nombre' => $this->faker->text,
        'segundo_nombre' => $this->faker->text,
        'fechanac' => $this->faker->text,
        'ci' => $this->faker->text,
        'sexo' => $this->faker->text,
        'grupo_sanguineo' => $this->faker->text,
        'nacionalidad' => $this->faker->text,
        'celular' => $this->faker->text,
        'domiciolio' => $this->faker->text,
        'ciudad' => $this->faker->text,
        'id_categoria' => $this->faker->text,
        'nombre_equipo' => $this->faker->text,
        'contacto_emergencia' => $this->faker->text,
        'nombre_apellido_contacto_emergencia' => $this->faker->text,
        'foto' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
