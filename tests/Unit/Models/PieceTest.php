<?php

namespace Tests\Unit\Models;

use App\Models\Piece;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\DataProvider;

// todo: check that they are in the same game
class PieceTest extends TestPieceCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->piece = Piece::factory()->createOne();
    }

    public function test_piece_has_friendly_in_position()
    {
        $friendlyPiece = $this->createFriendlyPiece();

        $this->assertTrue($this->piece->isFriendlyPosition($friendlyPiece->positionX, $friendlyPiece->positionY));
    }

    public function test_piece_has_friendly_in_positions()
    {
        $positions = [];
        for ($i = 0; $i < 3; $i++) {
            $friendlyPiece = $this->createFriendlyPiece();
            $positions[] = [$friendlyPiece->positionX, $friendlyPiece->positionY];
        }

        $this->assertTrue($this->piece->someFriendlyPositions($positions));
    }

    public function test_piece_has_enemy_in_position()
    {
        $enemyPiece = $this->createEnemyPiece();

        $this->assertTrue($this->piece->isEnemyPosition($enemyPiece->positionX, $enemyPiece->positionY));
    }

    public function test_piece_has_enemy_in_positions()
    {
        $positions = [];
        for ($i = 0; $i < 3; $i++) {
            $enemyPiece = $this->createEnemyPiece();
            $positions[] = [$enemyPiece->positionX, $enemyPiece->positionY];
        }

        $this->assertTrue($this->piece->someEnemyPositions($positions));
    }

    private function movesContainPiece(Piece $piece)
    {
        $this->assertContains(
            [$piece->positionX, $piece->positionY],
            $piece->moves->map(fn($move) => [$move->positionX, $move->positionY])->toArray()
        );
    }

    public function test_piece_creates_move_on_create()
    {
        $piece = Piece::factory()->createOne();

        $this->movesContainPiece($piece);
    }

    public function test_piece_creates_move_on_update()
    {
        $this->piece->positionX = rand(0, 7);
        $this->piece->positionY = rand(0, 7);
        $this->piece->save();

        $this->movesContainPiece($this->piece);
    }

    public function test_piece_moves_correctly()
    {
        // TODO
    }

    public function test_piece_kills_enemy()
    {
        // TODO
    }


    public static function piece_can_move_to_position_provider()
    {
        return [
            [
                [
                    ['1', '2'],
                    ['1', '3'],
                ],
                [
                    'x' => '1',
                    'y' => '2'
                ],
                true
            ],
            [
                [
                    ['1', '2'],
                ],
                [
                    'x' => '1',
                    'y' => '2'
                ],
                true
            ],
            [
                [
                    ['2', '2'],
                    ['2', '3'],
                ],
                [
                    'x' => '1',
                    'y' => '2'
                ],
                false
            ],
            [
                [],
                [
                    'x' => '1',
                    'y' => '2'
                ],
                false
            ],
        ];
    }

    #[DataProvider('piece_can_move_to_position_provider')]
    /**
     * @param array<array<string, string>> $availableMoves
     * @param array{x: string, y: string} $position
     */
    public function test_piece_can_move_to_position(array $availableMoves, array $position, bool $canMove)
    {
        $piece = $this->partialMock(Piece::class, function (MockInterface $mock) use ($availableMoves) {
            $mock->shouldReceive('availableMoves')->andReturn($availableMoves);
        });

        $this->assertEquals($piece->canMoveTo($position['x'], $position['y']), $canMove);
    }

    public static function piece_can_move_to_any_position_provider()
    {
        return [
            [
                [true, false],
                [
                    ['1', '2'],
                    ['1', '6'],
                ],
                true
            ],
            [
                [false, false],
                [
                    ['1', '2'],
                    ['1', '6'],
                ],
                false
            ],
            [
                [false, true],
                [
                    ['1', '2'],
                    ['1', '6'],
                ],
                true
            ],
            [
                [true, true],
                [
                    ['1', '2'],
                    ['1', '6'],
                ],
                true
            ],
        ];
    }


    #[DataProvider('piece_can_move_to_any_position_provider')]
    /**
     * @param array<array<bool>> $canMoveToPositions
     * @param array<array{x: string, y: string}> $positions
     */
    public function test_piece_can_move_to_any_of_the_positions(array $canMoveToPositions, array $positions, bool $canMoveToAny)
    {
        $piece = $this->partialMock(Piece::class, function (MockInterface $mock) use ($canMoveToPositions) {
            $mock->shouldReceive('canMoveTo')->andReturnValues($canMoveToPositions);
        });

        $this->assertEquals($piece->canMoveToAny($positions), $canMoveToAny);
    }

    public static function piece_can_prevent_piece_to_move_at_provider() {
        return [
            [
                [
                    'type' => 'pawn',
                    'x' => '2',
                    'y' => '2'
                ],
                [
                    'type' => 'queen',
                    'x' => '3',
                    'y' => '3'
                ],
                [
                    'x' => '5',
                    'y' => '5'
                ],
                true
            ],
            [
                [
                    'type' => 'bishop',
                    'x' => '2',
                    'y' => '2'
                ],
                [
                    'type' => 'queen',
                    'x' => '3',
                    'y' => '0'
                ],
                [
                    'x' => '3',
                    'y' => '6'
                ],
                true
            ],
            [
                [
                    'type' => 'bishop',
                    'x' => '2',
                    'y' => '2'
                ],
                [
                    'type' => 'queen',
                    'x' => '3',
                    'y' => '0'
                ],
                [
                    'x' => '3',
                    'y' => '6'
                ],
                true
            ],
            [
                [
                    'type' => 'bishop',
                    'x' => '5',
                    'y' => '4'
                ],
                [
                    'type' => 'knight',
                    'x' => '3',
                    'y' => '0'
                ],
                [
                    'x' => '4',
                    'y' => '3'
                ],
                false
            ],
            [
                [
                    'type' => 'bishop',
                    'x' => '2',
                    'y' => '2'
                ],
                [
                    'type' => 'queen',
                    'x' => '5',
                    'y' => '0'
                ],
                [
                    'x' => '5',
                    'y' => '5'
                ],
                false
            ],
            [
                [
                    'type' => 'rook',
                    'x' => '2',
                    'y' => '2'
                ],
                [
                    'type' => 'queen',
                    'x' => '7',
                    'y' => '7'
                ],
                [
                    'x' => '5',
                    'y' => '5'
                ],
                false
            ],
        ];
    }

    /**
     * @param array{type: string, x: string, y: string} $defendingPiece
     * @param array{type: string, x: string, y: string} $attackingPiece
     * @param array{x: string, y: string} $positionToPrevent
     * @param bool $shouldPrevent
     */
    #[DataProvider('piece_can_prevent_piece_to_move_at_provider')]
    public function test_piece_can_prevent_piece_to_move_at(array $defendingPiece, array $attackingPiece, array $positionToPrevent, bool $shouldPrevent) {
        $piece = Piece::factory()->createOne([
            'type' => $defendingPiece['type'],
            'positionX' => $defendingPiece['x'],
            'positionY' => $defendingPiece['y'],
        ]);
        $this->piece = Piece::find($piece->id);

        $enemyPiece = $this->createEnemyPiece([
            'type' => $attackingPiece['type'],
            'positionX' => $attackingPiece['x'],
            'positionY' => $attackingPiece['y'],
        ]);
        $enemyPiece = Piece::find($enemyPiece->id);

        $this->assertEquals($shouldPrevent, $this->piece->canPreventPieceToMoveAt($enemyPiece, $positionToPrevent['x'], $positionToPrevent['y']));
    }
}
