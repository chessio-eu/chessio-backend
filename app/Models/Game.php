<?php

namespace App\Models;

use App\Enums\Color;
use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @mixin IdeHelperGame
 */
class Game extends Model
{
    use HasFactory;

    protected $casts = ['status' => GameStatus::class];

    // Relationships

    function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    function pieces(): HasManyThrough
    {
        return $this->hasManyThrough(Piece::class, Player::class);
    }

    // Functions

    function whitePlayer(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->players->first(fn($player) => $player->color == Color::White)
        );
    }

    function blackPlayer(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->players->first(fn($player) => $player->color == Color::Black)
        );
    }

    private function createPawns()
    {
        for ($i = 0; $i < 8; $i++) {
            Pawn::create([
                'positionX' => $i,
                'positionY' => 1,
                'player_id' => $this->whitePlayer->id
            ]);

            Pawn::create([
                'positionX' => $i,
                'positionY' => 6,
                'player_id' => $this->blackPlayer->id
            ]);
        }
    }

    private function createRooks()
    {
        Rook::create(['positionX' => 0, 'positionY' => 0, 'player_id' => $this->whitePlayer->id]);
        Rook::create(['positionX' => 7, 'positionY' => 0, 'player_id' => $this->whitePlayer->id]);
        Rook::create(['positionX' => 0, 'positionY' => 7, 'player_id' => $this->blackPlayer->id]);
        Rook::create(['positionX' => 7, 'positionY' => 7, 'player_id' => $this->blackPlayer->id]);
    }

    private function createKnights()
    {
        Knight::create(['positionX' => 1, 'positionY' => 0, 'player_id' => $this->whitePlayer->id]);
        Knight::create(['positionX' => 6, 'positionY' => 0, 'player_id' => $this->whitePlayer->id]);
        Knight::create(['positionX' => 1, 'positionY' => 7, 'player_id' => $this->blackPlayer->id]);
        Knight::create(['positionX' => 6, 'positionY' => 7, 'player_id' => $this->blackPlayer->id]);
    }

    private function createBishops()
    {
        Bishop::create(['positionX' => 2, 'positionY' => 0, 'player_id' => $this->whitePlayer->id]);
        Bishop::create(['positionX' => 5, 'positionY' => 0, 'player_id' => $this->whitePlayer->id]);
        Bishop::create(['positionX' => 2, 'positionY' => 7, 'player_id' => $this->blackPlayer->id]);
        Bishop::create(['positionX' => 5, 'positionY' => 7, 'player_id' => $this->blackPlayer->id]);
    }

    private function createQueens()
    {
        Queen::create(['positionX' => 3, 'positionY' => 0, 'player_id' => $this->whitePlayer->id]);
        Queen::create(['positionX' => 3, 'positionY' => 7, 'player_id' => $this->blackPlayer->id]);
    }

    private function createKings()
    {
        King::create(['positionX' => 4, 'positionY' => 0, 'player_id' => $this->whitePlayer->id]);
        King::create(['positionX' => 4, 'positionY' => 7, 'player_id' => $this->blackPlayer->id]);
    }

    function createPieces(): self
    {
        if ($this->pieces()->count() > 0) {
            return $this;
        }

        $this->createPawns();
        $this->createRooks();
        $this->createKnights();
        $this->createBishops();
        $this->createQueens();
        $this->createKings();

        return $this;
    }

    function playerTurn(): Player
    {
        $whitePlayer = $this->whitePlayer;
        $blackPlayer = $this->blackPlayer;
        $whiteMove = $whitePlayer->latestMove();
        $blackMove = $blackPlayer->latestMove();
        return $whiteMove->id > $blackMove->id ? $blackPlayer : $whitePlayer;
    }
}
