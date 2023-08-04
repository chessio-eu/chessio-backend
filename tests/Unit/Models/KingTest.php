<?php

namespace Tests\Unit\Models;

use App\Models\King;

class KingTest extends TestPieceCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->piece = King::factory()->createOne([
            'positionX' => 4,
            'positionY' => 5,
        ]);
    }

    private function moves(): array {
        return [
            [
                $this->piece->positionX - 1,
                $this->piece->positionY,
            ],
            [
                $this->piece->positionX - 1,
                $this->piece->positionY - 1,
            ],
            [
                $this->piece->positionX - 1,
                $this->piece->positionY + 1,
            ],
            [
                $this->piece->positionX + 1,
                $this->piece->positionY,
            ],
            [
                $this->piece->positionX + 1,
                $this->piece->positionY - 1,
            ],
            [
                $this->piece->positionX + 1,
                $this->piece->positionY + 1,
            ],
            [
                $this->piece->positionX ,
                $this->piece->positionY + 1,
            ],
            [
                $this->piece->positionX,
                $this->piece->positionY - 1,
            ],
        ];
    }

    public function test_king_can_move_everywhere_around_him()
    {
        $expectedMoves = $this->moves();
        $availableMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing($expectedMoves, $availableMoves);
    }

    public function test_king_is_blocked_by_friendly_piece()
    {
        $friendlyPositionX = $this->piece->positionX + 1;
        $friendlyPositionY = $this->piece->positionY;
        $friendlyPiece = $this->createFriendlyPiece([
            'positionX' => $friendlyPositionX,
            'positionY' => $friendlyPositionY
        ]);
        $resultMoves = $this->piece->availableMoves();

        $this->assertNotContains([$friendlyPositionX, $friendlyPositionY], $resultMoves);
    }

    public function test_king_is_not_blocked_by_enemy_piece() {
        $enemyPositionX = 5;
        $enemyPositionY = 5;
        $friendlyPiece = $this->createEnemyPiece([
            'positionX' => $enemyPositionX,
            'positionY' => $enemyPositionY
        ]);
        $resultMoves = $this->piece->availableMoves();

        $this->assertContains([$enemyPositionX, $enemyPositionY], $resultMoves);
    }
}
