<?php

namespace App\Support\CurrentPlayer\Listeners;

use App\Events\PlayerJoinedGame;
use App\Support\CurrentPlayer\CurrentPlayer;

class SetCurrentPlayer {
    protected CurrentPlayer $currentPlayer;
    public function __construct(CurrentPlayer $currentPlayer) {
        $this->currentPlayer = $currentPlayer;
    }

    public function handle(PlayerJoinedGame $event): void
    {
        $this->currentPlayer->set($event->player);
    }
}
