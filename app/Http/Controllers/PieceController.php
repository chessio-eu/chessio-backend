<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovePieceRequest;
use App\Models\Piece;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    public function move(MovePieceRequest $request, Piece $piece) {
        $piece->move($request->positionX, $request->positionY);

        return $piece;
    }

    public function availableMoves(Piece $piece) {
        return $piece->availableMoves();
    }
}
