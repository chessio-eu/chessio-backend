<?php

namespace App\Listeners;

use App\Events\KingIsThreatened;
use App\Events\PieceMoved;
use App\Models\King;

class CheckKingStatus
{
    public function handle(PieceMoved $event): void
    {
        $enemyKing = King::wherePlayerId($event->piece->player->enemy()->id)->first();

        if ($enemyKing->isThreatened()) {
            KingIsThreatened::dispatch($enemyKing);
        }
    }
}
