<?php

namespace App\Models;

use App\Enums\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @mixin IdeHelperPlayer
 */
class Player extends Model
{
    use HasFactory;

    protected $casts = ['color' => Color::class];

    function pieces(): HasMany {
        return $this->hasMany(Piece::class);
    }

    function moves(): HasManyThrough {
        return $this->hasManyThrough(Move::class, Piece::class)->orderByDesc('id');
    }

    function game(): BelongsTo {
        return $this->belongsTo(Game::class);
    }

    function enemy(): static {
        return $this->game->players()->whereNot('id', $this->id)->first();
    }

    function latestMove(): Move {
        // TODO
    }
}
