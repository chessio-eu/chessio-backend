<?php

namespace Tests\Unit\Models;

use App\Enums\Color;
use App\Models\Piece;
use App\Models\Player;
use Event;
use Tests\TestCase;

abstract class TestPieceCase extends TestCase
{
    protected Piece $piece;

    protected function createFriendlyPiece($atts = []): Piece
    {
        return Piece::factory()->createOne(array_merge([
            'player_id' => $this->piece->player_id
        ], $atts));
    }

    protected function createEnemyPiece($atts = [], Player | null $player = null): Piece
    {
        $player ??= Player::factory()
            ->createOne(['color' => Color::Black, 'game_id' => $this->piece->game->id]);

        return Piece::factory()
            ->for($player)
            ->createOne($atts);
    }
}
