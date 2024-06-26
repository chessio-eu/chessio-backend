<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerTurnEnds
{
    use Dispatchable, SerializesModels;

    public function __construct(public Player $player)
    {
    }
}
