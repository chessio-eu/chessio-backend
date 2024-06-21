<?php

namespace App\Models;

use App\Enums\Color;
use App\Events\PieceMoved;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;

/**
 * @mixin IdeHelperPiece
 */
class Piece extends Model
{
    use HasFactory, HasChildren;

    protected $fillable = ['positionX', 'positionY', 'player_id', 'type'];

    protected $appends = ['color'];

    protected $childTypes = [
        'pawn' => Pawn::class,
        'bishop' => Bishop::class,
        'king' => King::class,
        'rook' => Rook::class,
        'knight' => Knight::class,
        'queen' => Queen::class
    ];

    // Relationships

    function player() {
        return $this->belongsTo(Player::class);
    }

    function game() {
        return $this->hasOneThrough(Game::class, Player::class, 'id', 'id', 'player_id', 'game_id');
    }

    function moves() {
        return $this->hasMany(Move::class)->orderByDesc('id');
    }

    function previousMove(): Move | null {
        return $this->moves()->skip(1)->first();
    }

    // Functions
    function color(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->player->color
        );
    }

    function isFriendlyPosition($positionX, $positionY) {
        return $this->someFriendlyPositions([[$positionX, $positionY]]);
    }

    function someFriendlyPositions($positions): bool {
        $piece = Piece::query()->whereHas('player', fn($player) => $player->whereId($this->player->id));

        $piece = $piece->where(function($query) use ($positions) {
            foreach ($positions as $position) {
                $query = $query->orWhere(fn($piece) => $piece->where('positionX', $position[0])->where('positionY' ,$position[1]));
            }
        });

        return $piece->exists();
    }

    function isEnemyPosition($positionX, $positionY) {
        return $this->someEnemyPositions([[$positionX, $positionY]]);
    }

    function someEnemyPositions($positions): bool {
        $piece = Piece::query()->whereHas('player', fn ($player) => $player->whereNot('color', $this->color))
            ->whereHas('game', fn($game) => $game->where('games.id', $this->game->id));

        $piece = $piece->where(function($query) use ($positions) {
            foreach ($positions as $position) {
                $query = $query->orWhere(fn($piece) => $piece->where('positionX', $position[0])->where('positionY' ,$position[1]));
            }
        });

        return $piece->exists();
    }

    public function removeFromBoard() {
        $this->positionX = -1;
        $this->positionY = -1;
        $this->save();
        PieceMoved::dispatch($this);
    }

    private function killEnemy(int $positionX, int $positionY) {
        $enemyPiece = Piece::query()->where('positionX', $positionX)->where('positionY', $positionY)->whereHas('player', fn ($player) => $player->whereNot('color', $this->color))
            ->whereHas('game', fn($game) => $game->where('games.id', $this->game->id))->first();
        $enemyPiece->removeFromBoard();
    }

    function getColorParamAttribute() {
        return $this->color === Color::White ? 1 : -1;
    }

    function move(int $positionX, int $positionY) {
        if (!$this->canMoveTo($positionX, $positionY)) {
            throw new \Error('Invalid move');
        }

        $this->positionX = $positionX;
        $this->positionY = $positionY;

        if ($this->isEnemyPosition($positionX, $positionY)) {
            $this->killEnemy($positionX, $positionY);
        }

        $this->save();
        PieceMoved::dispatch($this);
    }

    function availableMoves(): array {return [];}

    function canMoveTo(int $positionX, int $positionY): bool {
        return in_array([$positionX, $positionY], $this->availableMoves());
    }

    /**
     * @param array{int, int}[] $positions
     */
    function canMoveToAny(array $positions): bool {
        foreach ($positions as $position) {
            if ($this->canMoveTo($position[0], $position[1])) {
                return true;
            }
        }
       return false;
    }

    /**
     * @param array{x: int, y: int} $positionA
     * @param array{x: int, y: int} $positionB
     * @param array{x: int, y: int} $positionC
     */
    protected function onSameLine(array $positionA, array $positionB, array $positionC): bool {
        if ($positionA['x'] === $positionB['x']) {
            if ($positionC['x'] === $positionB['x']) {
                return true;
            }

            return false;
        }

        $onSameLine = fn (): bool => $positionC['y'] === (($positionB["y"] - $positionA['y']) / ($positionB["x"] - $positionA['x']) * ($positionC['x'] - $positionA["x"]) + $positionA["y"]);

        if ($onSameLine()) {
            return true;
        }

        return false;
    }

    /**
     *  @return array{int, int}[] $positions
     */
    protected function generatePositionsInLine(int $fromPositionX, int $fromPositionY, int $toPositionX, int $toPositionY): array {
        $moves = [];

        $minX = min($fromPositionX, $toPositionX);
        $maxX = max($fromPositionX, $toPositionX);
        $minY = min($fromPositionY, $toPositionY);
        $maxY = max($fromPositionY, $toPositionY);

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                if ($this->onSameLine(['x' => $fromPositionX, 'y' => $fromPositionY], ['x' => $toPositionX, 'y' => $toPositionY], ['x' => $x, 'y' => $y])) {
                    $moves[] = [$x, $y];
                }
            }
        }

        return $moves;
    }

    function canPreventPieceToMoveAt(Piece $attackingPiece, int $positionX, int $positionY): bool {
        if ($this->canMoveTo($attackingPiece->positionX, $attackingPiece->positionY)) {
            return true;
        }

        if ($attackingPiece->type === $this->classToAlias(Knight::class)) {
            return false;
        }

        $positions = $this->generatePositionsInLine($attackingPiece->positionX, $attackingPiece->positionY, $positionX, $positionY);
        $positions = array_filter($positions, function (array $position) use ($positionX, $positionY) {
            return $position !== [$positionX, $positionY];
        });
        if ($this->canMoveToAny($positions)) {
            return true;
        }

        return false;
    }
}
