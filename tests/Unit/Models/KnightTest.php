<?php

namespace Tests\Unit\Models;

use App\Models\Knight;

class KnightTest extends TestPieceCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->piece = Knight::factory()->createOne([
            'positionX' => 4,
            'positionY' => 5,
        ]);
    }

    private function moves() {
        return [
            [
                $this->piece->positionX - 1,
                $this->piece->positionY + 2,
            ],
            [
                $this->piece->positionX + 1,
                $this->piece->positionY + 2,
            ],
            [
                $this->piece->positionX - 2,
                $this->piece->positionY + 1,
            ],
            [
                $this->piece->positionX + 2,
                $this->piece->positionY + 1,
            ],
            [
                $this->piece->positionX - 2,
                $this->piece->positionY - 1,
            ],
            [
                $this->piece->positionX + 2,
                $this->piece->positionY - 1,
            ],
            [
                $this->piece->positionX - 1,
                $this->piece->positionY - 2,
            ],
            [
                $this->piece->positionX + 1,
                $this->piece->positionY - 2,
            ],
        ];
    }

    public function test_knight_can_move_properly()
    {
        $expectedMoves = $this->moves();
        $resultMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing($expectedMoves, $resultMoves);
    }

    public function test_knight_is_blocked_by_friendly_piece() {
        $positionX = $this->piece->positionX + 2;
        $positionY = $this->piece->positionY - 1;
        $friendlyPiece = $this->createFriendlyPiece([
            'positionX' => $positionX,
            'positionY' => $positionY
        ]);

        $resultMoves = $this->piece->availableMoves();

        $this->assertNotContains([$positionX, $positionY], $resultMoves);
    }
}
