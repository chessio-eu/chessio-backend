<?php

namespace Tests\Unit\Models;

use App\Models\Piece;

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
}
