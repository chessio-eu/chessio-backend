<?php

namespace App\Listeners;

use App\Events\GameTied;
use App\Events\KingIsChecked;
use App\Events\PlayerTurnEnds;
use App\Events\PlayerWins;
use App\Models\King;

class DetermineGameStatus
{
    public function handle(PlayerTurnEnds $event): void
    {
        /** @var King $enemyKing */
        $enemyKing = King::wherePlayerId($event->player->enemy()->id)->first();
        $enemyKingCanMove = count($enemyKing->availableMoves()) > 0;
        if ($enemyKing->isChecked()) {
            KingIsChecked::dispatch($enemyKing);

            if (!$enemyKingCanMove) {
                $checkingPieces = $enemyKing->checkingPieces();
                if ($checkingPieces->count() > 1) {
                    PlayerWins::dispatch($event->player);
                    return;
                }

                $checkingPiece = $checkingPieces->first();
                // find a piece that can prevent checkingPiece to kill the king
                $preventingPiece = $enemyKing->player->pieces->first(
                    fn($piece) => $piece->canPreventPieceToMoveAt($checkingPiece, $enemyKing->positionX, $enemyKing->positionY)
                );
                if (!$preventingPiece) {
                    PlayerWins::dispatch($event->player);
                }
            }

            return;
        }

        if (!$enemyKingCanMove) {
            $enemyPieceThatCanMove = $event->player->enemy()->pieces->first(fn($enemyPiece) => !empty($enemyPiece->availableMoves()));
            if (!$enemyPieceThatCanMove) {
                GameTied::dispatch($event->player->game);
            }
        }
    }
}
