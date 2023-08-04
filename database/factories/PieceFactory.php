<?php

namespace Database\Factories;

use App\Models\Piece;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Piece>
 */
class PieceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $childTypes = array_keys((new Piece)->getChildTypes());
        $randomIndex = rand(0, count($childTypes) - 1);
        $randomType = $childTypes[$randomIndex];
        $randomPositionX = rand(0, 7);
        $randomPositionY = rand(0, 7);
        return [
            'player_id' => Player::factory(),
            'type' => $randomType,
            'positionX' => $randomPositionX,
            'positionY' => $randomPositionY
        ];
    }
}
