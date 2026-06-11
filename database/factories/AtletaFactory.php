<?php

namespace Database\Factories;

use App\Models\Atleta;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtletaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Atleta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombres' => $this->faker->text,
        'apellidos' => $this->faker->text,
        'ci' => $this->faker->text,
        'sexo' => $this->faker->text,
        'celular' => $this->faker->text,
        'ciudad' => $this->faker->text,
        'departamento' => $this->faker->text,
        'categoria' => $this->faker->text,
        'tipo_categoria' => $this->faker->text,
        'nombre_equipo' => $this->faker->text,
        'federacion_id' => $this->faker->text,
        'uci_id' => $this->faker->text,
        'modo' => $this->faker->text,
        'id_user' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
