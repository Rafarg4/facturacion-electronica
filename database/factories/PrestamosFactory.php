<?php

namespace Database\Factories;

use App\Models\Prestamos;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrestamosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prestamos::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_cliente' => $this->faker->text,
        'monto' => $this->faker->text,
        'fecha_inicio' => $this->faker->text,
        'fecha_pago' => $this->faker->text,
        'fecha_vencimineto' => $this->faker->text,
        'cantidad_cuota' => $this->faker->text,
        'tipo_prestamo' => $this->faker->text,
        'dias_mora' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
