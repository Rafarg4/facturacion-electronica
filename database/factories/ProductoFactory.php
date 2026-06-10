<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->text,
        'descripcion' => $this->faker->text,
        'id_categoria' => $this->faker->text,
        'cantidad' => $this->faker->text,
        'cantidad_minima' => $this->faker->text,
        'precio_venta' => $this->faker->text,
        'precio_compra' => $this->faker->text,
        'estado' => $this->faker->text,
        'id_proveedor' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
