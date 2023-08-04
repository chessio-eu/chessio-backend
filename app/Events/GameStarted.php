<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameStarted implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(public Game $game)
    {
    }

    public function broadcastOn()
    {
        return new Channel('games');
    }

    public function broadcastAs()
    {
        return 'game.started.'.$this->game->id;
    }
}
