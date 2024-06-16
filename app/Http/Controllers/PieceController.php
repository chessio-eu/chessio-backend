<?php

namespace App\Http\Controllers;

use App\Events\PlayerTurnEnds;
use App\Http\Requests\MovePieceRequest;
use App\Models\Piece;

class PieceController extends Controller
{
    public function move(MovePieceRequest $request, Piece $piece) {
        $piece->move($request->positionX, $request->positionY);

        PlayerTurnEnds::dispatch($piece->player);

        return $piece;
    }

    public function availableMoves(Piece $piece) {
        return $piece->availableMoves();
    }
}
