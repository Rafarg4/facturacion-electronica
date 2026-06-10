<?php

namespace Database\Factories;

use App\Models\Compra;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Compra::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_proveedor' => $this->faker->text,
        'fecha_compra' => $this->faker->text,
        'tipo_comprobante' => $this->faker->text,
        'numero_comprobante' => $this->faker->text,
        'total' => $this->faker->text,
        'iva' => $this->faker->text,
        'forma_pago' => $this->faker->text,
        'condicion_compra' => $this->faker->text,
        'estado' => $this->faker->text,
        'id_caja' => $this->faker->text,
        'observacion' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
