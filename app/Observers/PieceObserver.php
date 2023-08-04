<?php

namespace App\Observers;

use App\Models\Move;
use App\Models\Piece;

class PieceObserver
{
    public function saved(Piece $piece) {
        $piece->createMoveIfNecessary();
    }
}
