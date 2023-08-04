<?php

namespace Tests\Unit\Models;

use App\Enums\Color;
use App\Models\Piece;
use App\Models\Player;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

abstract class TestPieceCase extends TestCase
{
    use WithoutEvents;

    protected Piece $piece;

    protected function createFriendlyPiece($atts = []): Piece
    {
        return Piece::factory()->createOne(array_merge([
            'player_id' => $this->piece->player_id
        ], $atts));
    }

    protected function createEnemyPiece($atts = []): Piece
    {
        return Piece::factory()
            ->for(Player::factory()
                ->createOne(['color' => Color::Black, 'game_id' => $this->piece->game->id]))
            ->createOne($atts);
    }
}
