<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

/**
 * @mixin IdeHelperKnight
 */
class Knight extends Piece
{
    use HasFactory, HasParent;

    function availableMoves(): array
    {
        $moves = [];
        for ($i = -2; $i <= 2; $i++) {
            for ($j = -2; $j <= 2; $j++) {
                $positionX = $this->positionX + $i;
                $positionY = $this->positionY + $j;

                // todo: test position < 8 and maybe move this logic in another function
                if ($positionX >= 0 && $positionY >= 0 && $positionX < 8
                    && $positionY < 8 && pow($i, 2) + pow($j, 2) === 5
                    && !$this->isFriendlyPosition($positionX, $positionY)) {
                    $moves[] = [$positionX, $positionY];
                }
            }
        }

        return $moves;
    }
}
