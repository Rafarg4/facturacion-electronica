<?php

namespace Database\Factories;

use App\Models\Ranking;
use Illuminate\Database\Eloquent\Factories\Factory;

class RankingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ranking::class;

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
        '1_fecha' => $this->faker->text,
        '2_fecha' => $this->faker->text,
        '3_fecha' => $this->faker->text,
        '4_fecha' => $this->faker->text,
        'total' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
