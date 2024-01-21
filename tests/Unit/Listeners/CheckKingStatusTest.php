<?php

namespace Unit\Listeners;

use App\Events\KingIsThreatened;
use App\Models\Piece;
use App\Models\Player;
use App\Models\Rook;
use Event;
use Tests\TestCase;

class CheckKingStatusTest extends TestCase
{
    // TODO: rewrite this to an integration test
    public function test_it_dispatches_king_is_threatened_when_piece_has_moved()
    {
        $king = Piece::factory()->createOne(['type' => 'king', 'positionX' => 1, 'positionY' => 1]);
        $player = Player::factory()->createOne(['game_id' => $king->game->id]);
        Piece::factory()->for($player)->createOne(['type' => 'rook', 'positionX' => 4, 'positionY' => 3]);
        $enemy = Rook::first();

        Event::fake([KingIsThreatened::class]);

        $enemy->move(1, 3);
        Event::assertDispatched(KingIsThreatened::class);
    }

    // TODO: rewrite this to an integration test
    public function test_it_doesnt_dispatch_king_is_threatened_when_piece_has_moved()
    {
        $king = Piece::factory()->createOne(['type' => 'king', 'positionX' => 1, 'positionY' => 1]);
        $player = Player::factory()->createOne(['game_id' => $king->game->id]);
        Piece::factory()->for($player)->createOne(['type' => 'rook', 'positionX' => 4, 'positionY' => 3]);
        $enemy = Rook::first();

        Event::fake([KingIsThreatened::class]);

        $enemy->move(2, 3);
        Event::assertNotDispatched(KingIsThreatened::class);
    }
}
