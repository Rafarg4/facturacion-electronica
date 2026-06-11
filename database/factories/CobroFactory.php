<?php

namespace Database\Factories;

use App\Models\Cobro;
use Illuminate\Database\Eloquent\Factories\Factory;

class CobroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cobro::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_cliente' => $this->faker->text,
        'id_venta' => $this->faker->text,
        'fecha_cobro' => $this->faker->text,
        'cajero' => $this->faker->text,
        'observacion' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
