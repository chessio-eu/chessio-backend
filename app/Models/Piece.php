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
        return $this->hasMany(Move::class);
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
        $piece = Piece::query()->whereHas('player', fn ($player) => $player->whereNot('color', $this->player->color))
            ->whereHas('game', fn($game) => $game->where('games.id', $this->game->id));

        $piece = $piece->where(function($query) use ($positions) {
            foreach ($positions as $position) {
                $query = $query->orWhere(fn($piece) => $piece->where('positionX', $position[0])->where('positionY' ,$position[1]));
            }
        });

        return $piece->exists();
    }

    private function removeFromBoard() {
        $this->positionX = -1;
        $this->positionY = -1;
        $this->save();
    }

    private function killEnemy(int $positionX, int $positionY) {
        $enemyPiece = Piece::where('positionX', $positionX)->where('positionY', $positionY)
            ->whereHas('player',
                fn (Builder $playerQuery) => $playerQuery->where('id', $this->player->id));
        $enemyPiece->removeFromBoard();
    }

    function getColorParamAttribute() {
        return $this->player->color === Color::White ? 1 : -1;
    }

    function move(int $positionX, int $positionY) {
        if (!in_array([$positionX, $positionY], $this->availableMoves())) {
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

    function createMoveIfNecessary() {
        $changes = $this->getChanges();
        if ($this->wasRecentlyCreated || in_array('positionX', $changes) || in_array('positionY', $changes)) {
            $move = new Move();
            $move->positionX = $this->positionX;
            $move->positionY = $this->positionY;

            $this->moves()->save($move);
        }
    }

    function availableMoves(): array {return [];}
}
