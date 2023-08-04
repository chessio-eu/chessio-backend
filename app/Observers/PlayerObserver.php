<?php

namespace App\Observers;

use App\Events\PlayerJoinedGame;
use App\Events\PlayerJoiningGame;
use App\Models\Player;

class PlayerObserver
{
    public function creating(Player $player) {
        PlayerJoiningGame::dispatch($player);
    }

    public function created(Player $player)
    {
        PlayerJoinedGame::dispatch($player);
    }
}
