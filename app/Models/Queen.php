<?php

namespace App\Models;

use App\Traits\PieceMovesDiagonally;
use App\Traits\PieceMovesVertically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

/**
 * @mixin IdeHelperQueen
 */
class Queen extends Piece
{
    use HasFactory, HasParent, PieceMovesVertically, PieceMovesDiagonally;

    public function availableMoves(): array
    {
        return array_merge($this->verticalMoves(), $this->diagonalMoves());
    }
}
