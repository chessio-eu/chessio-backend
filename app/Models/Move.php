<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperMove
 */
class Move extends Model
{
    use HasFactory;

    function piece(): BelongsTo {
        return $this->belongsTo(Piece::class);
    }
}
