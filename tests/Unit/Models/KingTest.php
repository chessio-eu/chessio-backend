<?php

namespace Tests\Unit\Models;

use App\Models\King;
use App\Models\Knight;
use App\Models\Piece;
use App\Models\Queen;

/** @property King $piece */
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

    private function moves(): array
    {
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
                $this->piece->positionX,
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

    public function test_king_is_not_blocked_by_enemy_piece()
    {
        $enemyPositionX = 5;
        $enemyPositionY = 5;
        $friendlyPiece = $this->createEnemyPiece([
            'positionX' => $enemyPositionX,
            'positionY' => $enemyPositionY
        ]);
        $resultMoves = $this->piece->availableMoves();

        $this->assertContains([$enemyPositionX, $enemyPositionY], $resultMoves);
    }

    /**
     * @dataProvider providePiecesForCheckedKing
     */
    public function test_king_is_checked($enemyPieceBehindAtts, $enemyPieceInFrontAtts, $enemyPieceInFrontMove, $isKingTheatened)
    {
        $enemyPieceBehind = $this->createEnemyPiece([
            'type' => $enemyPieceBehindAtts['type'],
            'positionX' => $enemyPieceBehindAtts['positionX'],
            'positionY' => $enemyPieceBehindAtts['positionY'],
        ]);

        $this->createEnemyPiece([
            'type' => $enemyPieceInFrontAtts['type'],
            'positionX' => $enemyPieceInFrontAtts['positionX'],
            'positionY' => $enemyPieceInFrontAtts['positionY'],
        ], $enemyPieceBehind->player);

        $enemyPiece = Piece::where([
            ['type', $enemyPieceInFrontAtts['type']],
            ['positionX', $enemyPieceInFrontAtts['positionX']],
            ['positionY', $enemyPieceInFrontAtts['positionY']],
        ])->first();

        $enemyPiece->move($enemyPieceInFrontMove['positionX'], $enemyPieceInFrontMove['positionY']);


        $this->assertEquals($isKingTheatened, $this->piece->isChecked());
    }

    public static function providePiecesForCheckedKing()
    {
        return [
            [
                [
                    'type' => 'pawn',
                    'positionX' => 1,
                    'positionY' => 1,
                ],
                [
                    'type' => 'queen',
                    'positionX' => 6,
                    'positionY' => 3,
                ],
                [
                    'positionX' => 4,
                    'positionY' => 3,
                ],
                true
            ],
            [
                [
                    'type' => 'bishop',
                    'positionX' => 6,
                    'positionY' => 7,
                ],
                [
                    'type' => 'knight',
                    'positionX' => 5,
                    'positionY' => 6,
                ],
                [
                    'positionX' => 3,
                    'positionY' => 5,
                ],
                true
            ],
            [
                [
                    'type' => 'rook',
                    'positionX' => 4,
                    'positionY' => 3,
                ],
                [
                    'type' => 'bishop',
                    'positionX' => 4,
                    'positionY' => 4,
                ],
                [
                    'positionX' => 3,
                    'positionY' => 3,
                ],
                true
            ],
            [
                [
                    'type' => 'pawn',
                    'positionX' => 1,
                    'positionY' => 1,
                ],
                [
                    'type' => 'queen',
                    'positionX' => 4,
                    'positionY' => 3,
                ],
                [
                    'positionX' => 7,
                    'positionY' => 3,
                ],
                false
            ]
        ];
    }
}
