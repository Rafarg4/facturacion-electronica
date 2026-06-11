<?php

namespace Database\Factories;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_cliente' => $this->faker->text,
        'fecha_venta' => $this->faker->text,
        'id_usuario' => $this->faker->text,
        'tipo_comprobante' => $this->faker->text,
        'numero_comprobante' => $this->faker->text,
        'total' => $this->faker->text,
        'iva' => $this->faker->text,
        'forma_pago' => $this->faker->text,
        'estado' => $this->faker->text,
        'observacion' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
