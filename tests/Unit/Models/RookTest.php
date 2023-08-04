<?php

namespace Tests\Unit\Models;

use App\Models\Rook;

class RookTest extends TestPieceCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->piece = Rook::factory()->createOne(['positionX' => 5, 'positionY' => 5]);
    }

    public function test_rook_can_move()
    {
        $actualMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing([
            [7, 5],
            [6, 5],
            [4, 5],
            [3, 5],
            [2, 5],
            [1, 5],
            [0, 5],
            [5, 6],
            [5, 7],
            [5, 4],
            [5, 3],
            [5, 2],
            [5, 1],
            [5, 0]
        ], $actualMoves);
    }

    public function test_rook_is_friendly_blocked()
    {
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 6, 'positionY' => 5]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 2, 'positionY' => 5]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 5, 'positionY' => 7]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 5, 'positionY' => 3]);

        $actualMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing([
            [4, 5],
            [3, 5],
            [5, 6],
            [5, 4],
        ], $actualMoves);
    }

    public function test_rook_is_enemy_blocked()
    {
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 6, 'positionY' => 5]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 2, 'positionY' => 5]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 5, 'positionY' => 7]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 5, 'positionY' => 3]);

        $actualMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing([
            [4, 5],
            [3, 5],
            [5, 6],
            [5, 4],
            [5, 3],
            [6, 5],
            [2, 5],
            [5, 7],
        ], $actualMoves);
    }
}
