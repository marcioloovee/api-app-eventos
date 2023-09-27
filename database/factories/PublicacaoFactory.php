<?php

namespace Database\Factories;

use App\Models\Publicacao;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PublicacaoFactory extends Factory
{
    protected $model = Publicacao::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::all()->random()->usuario_id,
            'mensagem' => fake()->text(200),
            'image' => "https://picsum.photos/id/".rand(10,100)."/400/400",
            'curtidas' => 0,
        ];
    }
}
