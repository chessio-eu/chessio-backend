<?php

namespace App\Events;

use App\Models\Piece;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PieceMoved implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(public Piece $piece)
    {
    }

    public function broadcastOn()
    {
        return new Channel('games');
    }

    public function broadcastWith()
    {
        return [
            'positionX' => $this->piece->positionX,
            'positionY' => $this->piece->positionY
        ];
    }

    public function broadcastAs()
    {
        return "game.{$this->piece->game->id}.piece.{$this->piece->id}.moved";
    }
}
