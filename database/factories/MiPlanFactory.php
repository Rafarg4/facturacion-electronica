<?php

namespace Database\Factories;

use App\Models\MiPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class MiPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MiPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'empresa' => $this->faker->text,
        'nro_cuota' => $this->faker->text,
        'fecha_vencimiento' => $this->faker->word,
        'fecha_pago' => $this->faker->word,
        'monto_cuota' => $this->faker->text,
        'saldo_cuota' => $this->faker->text,
        'estado' => $this->faker->text,
        'observacion' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
