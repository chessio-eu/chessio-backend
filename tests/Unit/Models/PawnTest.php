<?php

namespace Tests\Unit\Models;

use App\Models\Pawn;

class PawnTest extends TestPieceCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->piece = Pawn::factory()->createOne([
            'positionX' => 1,
            'positionY' => 1,
        ]);
    }

    public function test_pawn_can_move_forward()
    {
        $this->assertContains(
            [$this->piece->positionX, $this->piece->positionY + $this->piece->colorParam],
            $this->piece->availableMoves()
        );
    }

    public function test_pawn_can_double_move_forward() {
        $this->assertContains(
            [$this->piece->positionX, $this->piece->positionY + 2*$this->piece->colorParam],
            $this->piece->availableMoves()
        );
    }

    public function test_pawn_can_move_only_forward() {
        $friendlyPawn = $this->createFriendlyPiece([
            'positionX' => $this->piece->positionX,
            'positionY' => $this->piece->positionY + 2*$this->piece->colorParam]
        );
        $this->piece->load('game');
        $this->assertEquals(
            [[$this->piece->positionX, $this->piece->positionY + $this->piece->colorParam]],
            $this->piece->availableMoves()
        );
    }

    public function test_pawn_is_blocked_by_friendly_piece() {
        $friendlyPawn = $this->createFriendlyPiece([
            'positionX' => $this->piece->positionX,
            'positionY' => $this->piece->positionY + $this->piece->colorParam]
        );
        $this->piece->load('game');

        $this->assertEquals([], $this->piece->availableMoves());
    }

    public function test_pawn_is_blocked_by_enemy_piece() {
        $enemyPawn = $this->createEnemyPiece([
            'positionX' => $this->piece->positionX,
            'positionY' => $this->piece->positionY + $this->piece->colorParam
        ]);
        $this->piece->load('game');

        $this->assertEquals([], $this->piece->availableMoves());
    }

    public function test_pawn_can_kill_at_start() {
        $enemyPawn = $this->createEnemyPiece([
            'positionX' => $this->piece->positionX - 1,
            'positionY' => $this->piece->positionY + $this->piece->colorParam
        ]);
        $this->piece->load('game');

        $this->assertContains(
            [$this->piece->positionX - 1, $this->piece->positionY + $this->piece->colorParam],
            $this->piece->availableMoves()
        );
    }

    public function test_pawn_can_kill_at_end() {
        $enemyPawn = $this->createEnemyPiece([
            'positionX' => $this->piece->positionX + 1,
            'positionY' => $this->piece->positionY + $this->piece->colorParam
        ]);
        $this->piece->load('game');

        $this->assertContains(
            [$this->piece->positionX + 1,  $this->piece->positionY + $this->piece->colorParam],
            $this->piece->availableMoves()
        );
    }
}
