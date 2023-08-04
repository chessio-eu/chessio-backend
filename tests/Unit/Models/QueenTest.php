<?php

namespace Tests\Unit\Models;

use App\Models\Queen;

class QueenTest extends TestPieceCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->piece = Queen::factory()->createOne([
            'positionX' => 4,
            'positionY' => 5,
        ]);
    }

    private function moves() {
        return [
            // Diagonial
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

            // Vertical
            [7, 5],
            [6, 5],
            [5, 5],
            [3, 5],
            [2, 5],
            [1, 5],
            [0, 5],
            [4, 6],
            [4, 7],
            [4, 4],
            [4, 3],
            [4, 2],
            [4, 1],
            [4, 0]
        ];
    }

    public function test_queen_can_move() {
        $expectedMoves = $this->moves();
        $resultMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing($expectedMoves, $resultMoves);
    }

    public function test_queen_is_friendly_blocked()
    {
        // Diagonial
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 6, 'positionY' => 7]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 2, 'positionY' => 3]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 3, 'positionY' => 6]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 7, 'positionY' => 2]);

        // Vertical
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 6, 'positionY' => 5]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 2, 'positionY' => 5]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 4, 'positionY' => 7]);
        $friendlyPiece = $this->createFriendlyPiece(['positionX' => 4, 'positionY' => 3]);

        $actualMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing([
            // Diagonial
            [5, 6],
            [3, 4],
            [5, 4],
            [6, 3],

            // Vertical
            [5, 5],
            [3, 5],
            [4, 6],
            [4, 4],
        ], $actualMoves);
    }

    public function test_queen_is_enemy_blocked()
    {
        // Diagonial
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 6, 'positionY' => 7]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 2, 'positionY' => 3]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 3, 'positionY' => 6]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 7, 'positionY' => 2]);

        // Vertical
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 6, 'positionY' => 5]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 2, 'positionY' => 5]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 4, 'positionY' => 7]);
        $friendlyPiece = $this->createEnemyPiece(['positionX' => 4, 'positionY' => 3]);


        $actualMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing([
            // Diagonial
            [6, 7],
            [2, 3],
            [3, 6],
            [7, 2],
            [5, 6],
            [3, 4],
            [5, 4],
            [6, 3],

            // Vertical
            [5, 5],
            [3, 5],
            [4, 6],
            [4, 4],
            [4, 3],
            [6, 5],
            [2, 5],
            [4, 7],
        ], $actualMoves);
    }
}
