<?php
namespace App\Traits;

use App\Enums\Axis;
use App\Enums\Direction;
use App\Models\Piece;

trait PieceMovesVertically {
    private function closestVertically(Axis $axis, Direction $direction): Piece|null
    {
        $query = Piece::query()->whereHas('game', fn($gameQuery) => $gameQuery->where('games.id', $this->game->id));
        if ($axis === Axis::X) {
            $query = $query->where('positionY', $this->positionY);
        } else {
            $query = $query->where('positionX', $this->positionX);
        }

        $positionStr = 'position'.$axis->value;
        $distance = $positionStr.'-'.$this->{$positionStr};
        if ($direction === Direction::Bottom || $direction === Direction::Left) {
            $distance = $this->{$positionStr}.'-'.$positionStr;
        }

        $query = $query->select('*')->selectRaw($distance.' as distance')->whereRaw($distance.' > 0')->orderBy('distance');

        return $query->first();
    }

    public function verticalMoves(): array  {
        $moves = [];

        $pieceLeft = $this->closestVertically(Axis::X, Direction::Left);
        $pieceLeftPosition = $pieceLeft->positionX ?? -1;
        if ($pieceLeft && $pieceLeft->color_param !== $this->color_param) {
            $pieceLeftPosition--;
        }

        $pieceRight = $this->closestVertically(Axis::X, Direction::Right);
        $pieceRightPosition = $pieceRight->positionX ?? 8;
        if ($pieceRight && $pieceRight->color_param !== $this->color_param) {
            $pieceRightPosition++;
        }

        for ($i = $pieceLeftPosition + 1; $i < $pieceRightPosition; $i++) {
            if ($i === $this->positionX) {
                continue;
            }

            $moves[] = [$i, $this->positionY];
        }

        $pieceBottom = $this->closestVertically(Axis::Y, Direction::Bottom);
        $pieceBottomPosition = $pieceBottom->positionY ?? -1;
        if ($pieceBottom && $pieceBottom->color_param !== $this->color_param) {
            $pieceBottomPosition--;
        }

        $pieceTop = $this->closestVertically(Axis::Y, Direction::Top);
        $pieceTopPosition = $pieceTop->positionY ?? 8;
        if ($pieceTop && $pieceTop->color_param !== $this->color_param) {
            $pieceTopPosition++;
        }

        for ($j = $pieceBottomPosition + 1; $j < $pieceTopPosition; $j++) {
            if ($j === $this->positionY) {
                continue;
            }

            $moves[] = [$this->positionX, $j];
        }

        return $moves;
    }
}
