<?php

namespace App\Http\Controllers;

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\Player;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index() {
        return Game::paginate(10);
    }

    public function get(Game $game, Request $request) {
        return $game->load('pieces');
    }

    public function playerTurn(Game $game, Request $request) {
        return $game->playerTurn();
    }

    public function find(Request $request) {
        $game = Game::where('status', GameStatus::Pending)->first();

        if ($game) {
            $player = new Player();
            $player->game_id = $game->id;
            $player->user_id = Auth::user()->id ?? null;
            $player->save();
            $game = $game->fresh();
        } else {
            $game = $this->store($request);
        }


        return $game;
    }

    public function store(Request $request) {
        $game = Game::create();

        $player = new Player();
        $player->game_id = $game->id;
        $player->user_id = Auth::user()->id ?? null;
        $player->save();

        return $game;
    }
}
