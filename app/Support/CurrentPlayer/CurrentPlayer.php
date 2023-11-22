<?php

namespace App\Support\CurrentPlayer;

use App\Models\Player;
use App\Support\CurrentPlayer\Contracts\PlayerAdapter;

class CurrentPlayer
{
    private Player | null $player;
    private PlayerAdapter $playerAdapter;

    public function __construct(PlayerAdapter $playerAdapter)
    {
        $this->player = $playerAdapter->retrieve();
        $this->playerAdapter = $playerAdapter;
    }

    public function get(): Player | null {
        return $this->player;
    }

    public function set(Player $player): void
    {
        $this->playerAdapter->set($player);
        $this->player = $player;
    }
}
