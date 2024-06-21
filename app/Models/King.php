<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
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

                if ($positionX >= 0 && $positionY >= 0 && $positionX < 8 && $positionY < 8
                    && !$this->isFriendlyPosition($positionX, $positionY)
                    && !$this->positionIsChecked($positionX, $positionY)) {
                    $moves[] = $move;
                }
            }
        }

        return $moves;
    }

    private function positionIsChecked($positionX, $positionY): bool {
        $enemyPieces = $this->player->enemy()->pieces;

        foreach ($enemyPieces as $piece) {
            if (in_array([$positionX, $positionY], $piece->availableMoves())) {
                return true;
            }
        }

        return false;
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

    private function pieceOnSameLine(int $positionX, int $positionY): Piece | null {
        return $this->player->enemy()->pieces
            ->filter(function (Piece $piece) use ($positionX, $positionY) {
                return $this->onSameLine(['x' => $this->positionX, 'y' => $this->positionY], ['x' => $positionX, 'y' => $positionY], ['x' => $piece->positionX, 'y' => $piece->positionY]);
            })
            ->sort(fn (Piece $pieceA, Piece $pieceB) => ($pieceA->positionX - $this->positionX + $pieceA->positionY - $this->positionY) < ($pieceB->positionX - $this->positionX + $pieceB->positionY - $this->positionY))
            ->first();
    }

    /**
     * @return Collection<int, Piece>
     */
    function checkingPieces(): Collection {
        $pieces = collect();
        $piece = $this->player->enemy()->moves->first()->piece; //TODO: refactor this implementation

        if ($this->isCheckedByPiece($piece)) {
            $pieces->add($piece);
        }

        $previousMove = $piece->previousMove();
        if ($previousMove) {
            $pieceOnSameLine = $this->pieceOnSameLine($previousMove->positionX, $previousMove->positionY);
            if ($pieceOnSameLine && $this->isCheckedByPiece($pieceOnSameLine)) {
                $pieces->add($pieceOnSameLine);
            }
        }

        return $pieces;
    }

    function isChecked(): bool {
        return $this->checkingPieces()->count() > 0;
    }
}
