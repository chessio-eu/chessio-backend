<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

/**
 * @mixin IdeHelperKing
 */
class King extends Piece
{
    use HasFactory, HasParent;

    function availableMoves(): array
    {
        $moves = [];

        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                $positionX = $this->positionX + $i;
                $positionY = $this->positionY + $j;
                $move = [$positionX, $positionY];

                if (!$this->isFriendlyPosition($positionX, $positionY)) {
                    $moves[] = $move;
                }
            }
        }

        return $moves;
    }

    private function isCheckedByPiece(Piece $piece): bool {
        $moves = $piece->availableMoves();
        foreach ($moves as $move) {
            if ($move[0] === $this->positionX && $move[1] === $this->positionY) {
                return true;
            }
        }

        return false;
    }

    private function pieceOnSameAxis(int $positionX, int $positionY): Piece | null {
        return $this->player->enemy()->pieces->filter(function(Piece $piece) use ($positionX, $positionY) {
            if ($positionX - $this->positionX === 0) {
                return true;
            }

            return $piece->positionY === ($positionY - $this->positionY) / ($positionX - $this->positionX) * ($piece->positionX - $this->positionX) + $this->positionY;
        })->sort(function (Piece $pieceA, Piece $pieceB) {
            return $pieceA->positionX - $this->positionX + $pieceA->positionY - $this->positionY < $pieceB->positionX - $this->positionX + $pieceB->positionY - $this->positionY;
        })->first();
    }

    function isChecked(): bool {
        $piece = $this->player->enemy()->moves->first()->piece; //TODO: refactor this implementation

        if ($this->isCheckedByPiece($piece)) {
            return true;
        }

        $previousMove = $piece->previousMove();
        $pieceOnSameAxis = $this->pieceOnSameAxis($previousMove->positionX, $previousMove->positionY);
        if ($pieceOnSameAxis && $this->isCheckedByPiece($pieceOnSameAxis)) {
            return true;
        }

        return false;
    }
}
