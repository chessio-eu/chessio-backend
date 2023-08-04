<?php

namespace App\Models;

use App\Traits\PieceMovesDiagonally;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

/**
 * @mixin IdeHelperBishop
 */
class Bishop extends Piece
{
    use HasFactory, HasParent, PieceMovesDiagonally;

    
    public function availableMoves(): array
    {
        return $this->diagonalMoves();
    }
}
