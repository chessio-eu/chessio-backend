<?php

namespace App\Listeners;

use App\Enums\GameStatus;
use App\Events\GameStarted;
use App\Events\PlayerJoinedGame;

class ProcessGame
{
    public function handle(PlayerJoinedGame $event)
    {
        $game = $event->player->game;
        $playersCount = $game->players()->count();
        if ($playersCount == 2) {
            $game->status = GameStatus::InProgress;
            $game->save();
            $game->createPieces();
            GameStarted::dispatch($game);
        }
    }
}
