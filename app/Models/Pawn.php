<?php

namespace App\Models;

use App\Enums\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

/**
 * @mixin IdeHelperPawn
 */
class Pawn extends Piece
{
    use HasFactory, HasParent;

    function frontPosition() {
        return $this->positionY + $this->colorParam;
    }

    function inFirstPosition() {
        return $this->positionY === ($this->player->color === Color::White ? 1 : 6);
    }

    function isBehindYAxis(Piece $piece) {
        return $piece->positionY === $this->frontPosition();
    }

    function isBehind(Piece $piece, $positionX) {
        return $piece->positionX === $positionX && $this->isBehindYAxis($piece);
    }

    function isDoubleBehind(Piece $piece) {
        return $piece->positionX === $this->positionX && ($this->positionY + 2*$this->colorParam === $piece->positionY);
    }

    function availableMoves(): array {
        $allPieces = $this->game->pieces;

        $enemyPieces = $allPieces->filter(fn($piece) => $piece->player_id !== $this->player_id);
        
        $moves = [];
        $frontPosition = $this->frontPosition();

        if ($allPieces->doesntContain(fn($piece) => $this->isBehind($piece, $this->positionX))
        ) {
            $moves[] = [$this->positionX, $frontPosition];

            if ($this->inFirstPosition() && $allPieces->doesntContain(fn($piece) => $this->isDoubleBehind($piece))) {
                $moves[] = [$this->positionX, $this->positionY + 2*$this->colorParam];
            }
        }

        $leftPosition = $this->positionX - 1;
        if ($enemyPieces->contains(fn($piece) => $this->isBehind($piece, $leftPosition))
        ) {
            $moves[] = [$leftPosition, $frontPosition];
        }

        $rightPosition = $this->positionX + 1;
        if ($enemyPieces->contains(fn($piece) => $this->isBehind($piece, $rightPosition))
        ) {
            $moves[] = [$rightPosition, $frontPosition];
        }

        return $moves;
    }
}
