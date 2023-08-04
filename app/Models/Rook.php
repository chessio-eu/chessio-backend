<?php

namespace App\Models;

use App\Traits\PieceMovesVertically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

/**
 * @mixin IdeHelperRook
 */
class Rook extends Piece
{
    use HasFactory, HasParent, PieceMovesVertically;

    public function availableMoves(): array
    {
        return $this->verticalMoves();
    }
}
