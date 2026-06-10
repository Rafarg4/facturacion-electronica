<?php

namespace Database\Factories;

use App\Models\RankingMTB;
use Illuminate\Database\Eloquent\Factories\Factory;

class RankingMTBFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RankingMTB::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'posicion' => $this->faker->text,
        'nombre_apellido' => $this->faker->text,
        'categoria' => $this->faker->text,
        'club' => $this->faker->text,
        'sexo' => $this->faker->text,
        'primer_fecha' => $this->faker->text,
        'total' => $this->faker->text,
        'ci' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
