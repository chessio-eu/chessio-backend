<?php

namespace Tests\Unit\Models;

use App\Enums\Color;
use App\Models\King;
use App\Models\Piece;
use App\Models\Player;
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
        Player::factory()
            ->createOne(['color' => Color::Black, 'game_id' => $this->piece->game->id]);
        $expectedMoves = $this->moves();
        $availableMoves = $this->piece->availableMoves();

        $this->assertEqualsCanonicalizing($expectedMoves, $availableMoves);
    }

    public function test_king_is_blocked_by_friendly_piece()
    {
        Player::factory()
            ->createOne(['color' => Color::Black, 'game_id' => $this->piece->game->id]);
        $friendlyPiece = $this->createFriendlyPiece([
            'positionX' => $this->piece->positionX + 1,
            'positionY' => $this->piece->positionY
        ]);
        $resultMoves = $this->piece->availableMoves();

        $this->assertNotContains([$friendlyPiece->positionX, $friendlyPiece->positionY], $resultMoves);
    }

    public function test_king_is_not_blocked_by_enemy_piece()
    {
        $enemy = $this->createEnemyPiece([
            'positionX' => 5,
            'positionY' => 5
        ]);
        $resultMoves = $this->piece->availableMoves();

        $this->assertContains([$enemy->positionX, $enemy->positionY], $resultMoves);
    }

    public function test_king_cant_move_to_enemy_available_move()
    {
        $friendlyPiece = $this->createEnemyPiece([
            'positionX' => 5,
            'positionY' => 7,
            'type' => Queen::class
        ]);
        $resultMoves = $this->piece->availableMoves();

        $this->assertNotContains([5, 5], $resultMoves);
        $this->assertNotContains([5, 6], $resultMoves);
        $this->assertNotContains([5, 4], $resultMoves);
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
                true,
                [
                    [
                        'type' => 'queen',
                        'positionX' => 4,
                        'positionY' => 3,
                    ],
                ]
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
                true,
                [
                    [
                        'type' => 'bishop',
                        'positionX' => 6,
                        'positionY' => 7,
                    ],
                ]
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
                true,
                [
                    [
                        'type' => 'rook',
                        'positionX' => 4,
                        'positionY' => 3,
                    ],
                ]
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
                false,
                []
            ],
            [
                [
                    'type' => 'bishop',
                    'positionX' => 2,
                    'positionY' => 3,
                ],
                [
                    'type' => 'knight',
                    'positionX' => 3,
                    'positionY' => 4,
                ],
                [
                    'positionX' => 2,
                    'positionY' => 6,
                ],
                true,
                [
                    [
                        'type' => 'bishop',
                        'positionX' => 2,
                        'positionY' => 3,
                    ],
                    [
                        'type' => 'knight',
                        'positionX' => 2,
                        'positionY' => 6,
                    ]
                ]
            ],
        ];
    }

    /**
     * @dataProvider providePiecesForCheckedKing
     */
    public function test_king_is_checked_by_pieces($enemyPieceBehindAtts, $enemyPieceInFrontAtts, $enemyPieceInFrontMove, $isKingTheatened, $checkingPieces)
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


        foreach ($checkingPieces as $checkingPieceData) {
            $checkingPiece = Piece::where([
                ['type', $checkingPieceData['type']],
                ['positionX', $checkingPieceData['positionX']],
                ['positionY', $checkingPieceData['positionY']],
            ])->first();
            $this->assertTrue($this->piece->checkingPieces()->contains(fn(Piece $piece) => $piece->id === $checkingPiece->id));
        }

        if (count($checkingPieces) === 0) {
            $this->assertTrue($this->piece->checkingPieces()->isEmpty());
        }
    }
}
