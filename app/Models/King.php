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
}
