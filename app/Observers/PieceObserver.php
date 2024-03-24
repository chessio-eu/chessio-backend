<?php

namespace App\Observers;

use App\Models\Move;
use App\Models\Piece;

class PieceObserver
{
    public function created(Piece $piece) {
        $move = new Move();
        $move->positionX = $piece->positionX;
        $move->positionY = $piece->positionY;

        $piece->moves()->save($move);
    }

    public function updated(Piece $piece) {
        $changes = $piece->getChanges();
        if (array_key_exists('positionX', $changes) || array_key_exists('positionY', $changes)) {
            $move = new Move();
            $move->positionX = $piece->positionX;
            $move->positionY = $piece->positionY;

            $piece->moves()->save($move);
        };
    }
}
