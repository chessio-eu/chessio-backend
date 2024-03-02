<?php

namespace App\Listeners;

use App\Events\KingIsChecked;
use App\Events\PieceMoved;
use App\Models\King;

class CheckKingStatus
{
    public function handle(PieceMoved $event): void
    {
        $enemyKing = King::wherePlayerId($event->piece->player->enemy()->id)->first();

        if ($enemyKing->isChecked()) {
            KingIsChecked::dispatch($enemyKing);
        }
    }
}
