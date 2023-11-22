<?php

namespace App\Support\CurrentPlayer\Contracts;

use App\Models\Player;

interface PlayerAdapter {
    function retrieve(): Player|null;

    function set(Player $player): void;
}
