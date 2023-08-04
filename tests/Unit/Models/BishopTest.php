<?php

namespace Tests\Unit\Models;

use App\Models\Bishop;

class BishopTest extends TestPieceCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->piece = Bishop::factory()->createOne([
            'positionX' => 4,
            'positionY' => 5,
        ]);
    }

    private function moves() {
        return [
            [5, 6],
            [6, 7],
            [3, 6],
            [2, 7],
            [3, 4],
            [2, 3],
            [1, 2],
            [0, 1],
            [5, 4],
            [6, 3],
            [7, 2],
        ];
    }

    public function test_bishop_can_move_diagonally() {
        $expectedMoves = $this->moves();
        $resultMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing($expectedMoves, $resultMoves);
    }

    public function test_bishop_is_friendly_blocked()
    {
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 6, 'positionY' => 7]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 2, 'positionY' => 3]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 3, 'positionY' => 6]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 7, 'positionY' => 2]);

        $actualMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing([
            [5, 6],
            [3, 4],
            [5, 4],
            [6, 3],
        ], $actualMoves);
    }

    public function test_bishop_is_enemy_blocked()
    {
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 6, 'positionY' => 7]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 2, 'positionY' => 3]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 3, 'positionY' => 6]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 7, 'positionY' => 2]);

        $actualMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing([
            [6, 7],
            [2, 3],
            [3, 6],
            [7, 2],
            [5, 6],
            [3, 4],
            [5, 4],
            [6, 3],
        ], $actualMoves);
    }
}
