<?php
namespace App\Traits;

use App\Enums\Direction;
use App\Models\Piece;

trait PieceMovesDiagonally {
    private function closestDiagonally(Direction $directionX, Direction $directionY): Piece|null
    {
        $query = Piece::query()->whereHas('game', fn($gameQuery) => $gameQuery->where('games.id', $this->game->id));
        if ($directionX === Direction::Right) {
            $query = $query->where('positionX', '>', $this->positionX);
        } else {
            $query = $query->where('positionX', '<', $this->positionX);
        }

        if ($directionY === Direction::Top) {
            $query = $query->where('positionY', '>', $this->positionY);
        } else {
            $query = $query->where('positionY', '<', $this->positionY);
        }

        $positionStr = 'positionX';
        $distance = $positionStr . '-' . $this->{$positionStr};
        if ($directionX === Direction::Left) {
            $distance = $this->{$positionStr} . '-' . $positionStr;
        }

        $query = $query->select('*')->selectRaw($distance . ' as distance')
            ->where(function ($position) {
                $position->whereRaw('positionX+positionY=' . $this->positionX + $this->positionY)->orWhereRaw('positionX-positionY=' . $this->positionX - $this->positionY);
            })->orderBy('distance');

        return $query->first();
    }

    public function diagonalMoves(): array  {
        $moves = [];

        $pieceLeftBottom = $this->closestDiagonally(Direction::Left, Direction::Bottom);
        $pieceLeftPosition = $pieceLeftBottom->positionX ?? -1;
        $pieceBottomPosition = $pieceLeftBottom->positionY ?? -1;
        if ($pieceLeftBottom && $pieceLeftBottom->color_param !== $this->color_param) {
            $pieceLeftPosition--;
            $pieceBottomPosition--;
        }
        for ($i = $pieceLeftPosition + 1; $i < $this->positionX; $i++) {
            for ($j = $pieceBottomPosition + 1; $j < $this->positionY; $j++) {
                if (($i + $j === $this->positionX + $this->positionY) || ($i - $j === $this->positionX - $this->positionY)
                ) {
                    $moves[] = [$i, $j];
                }
            }
        }

        $pieceLeftTop = $this->closestDiagonally(Direction::Left, Direction::Top);
        $pieceLeftPosition = $pieceLeftTop->positionX ?? -1;
        $pieceTopPosition = $pieceLeftTop->positionY ?? 8;
        if ($pieceLeftTop && $pieceLeftTop->color_param !== $this->color_param) {
            $pieceLeftPosition--;
            $pieceTopPosition++;
        }
        for ($i = $pieceLeftPosition + 1; $i < $this->positionX; $i++) {
            for ($j = $this->positionY + 1; $j < $pieceTopPosition; $j++) {
                if (($i + $j === $this->positionX + $this->positionY) || ($i - $j === $this->positionX - $this->positionY)
                ) {
                    $moves[] = [$i, $j];
                }
            }
        }

        $pieceRightTop = $this->closestDiagonally(Direction::Right, Direction::Top);
        $pieceRightPosition = $pieceRightTop->positionX ?? 8;
        $pieceTopPosition = $pieceRightTop->positionY ?? 8;
        if ($pieceRightTop && $pieceRightTop->color_param !== $this->color_param) {
            $pieceRightPosition++;
            $pieceTopPosition++;
        }
        for ($i = $this->positionX + 1; $i < $pieceRightPosition; $i++) {
            for ($j = $this->positionY + 1; $j < $pieceTopPosition; $j++) {
                if (($i + $j === $this->positionX + $this->positionY) || ($i - $j === $this->positionX - $this->positionY)
                ) {
                    $moves[] = [$i, $j];
                }
            }
        }

        $pieceRightBottom = $this->closestDiagonally(Direction::Right, Direction::Bottom);
        $pieceRightPosition = $pieceRightBottom->positionX ?? 8;
        $pieceBottomPosition = $pieceRightBottom->positionY ?? -1;
        if ($pieceRightBottom && $pieceRightBottom->color_param !== $this->color_param) {
            $pieceRightPosition++;
            $pieceBottomPosition--;
        }
        for ($i = $this->positionX + 1; $i < $pieceRightPosition; $i++) {
            for ($j = $pieceBottomPosition + 1; $j < $this->positionY; $j++) {
                if (($i + $j === $this->positionX + $this->positionY) || ($i - $j === $this->positionX - $this->positionY)
                ) {
                    $moves[] = [$i, $j];
                }
            }
        }

        return $moves;
    }
}
