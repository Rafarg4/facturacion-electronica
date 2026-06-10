<?php

namespace Database\Factories;

use App\Models\Cierre;
use Illuminate\Database\Eloquent\Factories\Factory;

class CierreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cierre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_cobrador' => $this->faker->text,
        'monto_cierre' => $this->faker->text,
        'fecha_cierre' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
