<?php

namespace Database\Factories;

use App\Enums\Color;
use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
//            'time' => 5000,
            'color' => Color::White,
            'game_id' => Game::factory()
        ];
    }
}
