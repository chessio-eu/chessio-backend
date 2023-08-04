<?php

namespace App\Listeners;

use App\Enums\Color;
use App\Events\PlayerJoiningGame;

class SetupPlayerColor
{
    public function handle(PlayerJoiningGame $event)
    {
        $player = $event->player;
        $game = $player->game;
        if ($game->players()->count() == 1) {
            $player->color = Color::Black;
        }

        if (!$player->color) {
            $player->color = Color::White;
        }
    }
}
