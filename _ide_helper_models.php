<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Bishop
 *
 * @property int $id
 * @property string $type
 * @property int $positionX
 * @property int $positionY
 * @property int $player_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game|null $game
 * @property-read mixed $color_param
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Move[] $moves
 * @property-read int|null $moves_count
 * @property-read \App\Models\Player $player
 * @method static \Database\Factories\BishopFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop wherePositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop wherePositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bishop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperBishop {}
}

namespace App\Models{
/**
 * App\Models\Game
 *
 * @property int $id
 * @property \App\Enums\GameStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Piece[] $pieces
 * @property-read int|null $pieces_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Player[] $players
 * @property-read int|null $players_count
 * @method static \Database\Factories\GameFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperGame {}
}

namespace App\Models{
/**
 * App\Models\King
 *
 * @property int $id
 * @property string $type
 * @property int $positionX
 * @property int $positionY
 * @property int $player_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game|null $game
 * @property-read mixed $color_param
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Move[] $moves
 * @property-read int|null $moves_count
 * @property-read \App\Models\Player $player
 * @method static \Database\Factories\KingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|King newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|King newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|King query()
 * @method static \Illuminate\Database\Eloquent\Builder|King whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|King whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|King wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|King wherePositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|King wherePositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|King whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|King whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperKing {}
}

namespace App\Models{
/**
 * App\Models\Knight
 *
 * @property int $id
 * @property string $type
 * @property int $positionX
 * @property int $positionY
 * @property int $player_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game|null $game
 * @property-read mixed $color_param
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Move[] $moves
 * @property-read int|null $moves_count
 * @property-read \App\Models\Player $player
 * @method static \Database\Factories\KnightFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Knight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Knight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Knight query()
 * @method static \Illuminate\Database\Eloquent\Builder|Knight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Knight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Knight wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Knight wherePositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Knight wherePositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Knight whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Knight whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperKnight {}
}

namespace App\Models{
/**
 * App\Models\Move
 *
 * @property int $id
 * @property int $positionX
 * @property int $positionY
 * @property int $piece_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Move newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Move newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Move query()
 * @method static \Illuminate\Database\Eloquent\Builder|Move whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Move whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Move wherePieceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Move wherePositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Move wherePositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Move whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperMove {}
}

namespace App\Models{
/**
 * App\Models\Pawn
 *
 * @property int $id
 * @property string $type
 * @property int $positionX
 * @property int $positionY
 * @property int $player_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game|null $game
 * @property-read mixed $color_param
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Move[] $moves
 * @property-read int|null $moves_count
 * @property-read \App\Models\Player $player
 * @method static \Database\Factories\PawnFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn wherePositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn wherePositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pawn whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperPawn {}
}

namespace App\Models{
/**
 * App\Models\Piece
 *
 * @property int $id
 * @property string $type
 * @property int $positionX
 * @property int $positionY
 * @property int $player_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game|null $game
 * @property-read mixed $color_param
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Move[] $moves
 * @property-read int|null $moves_count
 * @property-read \App\Models\Player $player
 * @method static \Database\Factories\PieceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Piece newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Piece newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Piece query()
 * @method static \Illuminate\Database\Eloquent\Builder|Piece whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Piece whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Piece wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Piece wherePositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Piece wherePositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Piece whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Piece whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperPiece {}
}

namespace App\Models{
/**
 * App\Models\Player
 *
 * @property int $id
 * @property int $time
 * @property \App\Enums\Color $color
 * @property int|null $user_id
 * @property int $game_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Move[] $moves
 * @property-read int|null $moves_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Piece[] $pieces
 * @property-read int|null $pieces_count
 * @method static \Database\Factories\PlayerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperPlayer {}
}

namespace App\Models{
/**
 * App\Models\Queen
 *
 * @property int $id
 * @property string $type
 * @property int $positionX
 * @property int $positionY
 * @property int $player_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game|null $game
 * @property-read mixed $color_param
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Move[] $moves
 * @property-read int|null $moves_count
 * @property-read \App\Models\Player $player
 * @method static \Database\Factories\QueenFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Queen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Queen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Queen query()
 * @method static \Illuminate\Database\Eloquent\Builder|Queen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Queen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Queen wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Queen wherePositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Queen wherePositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Queen whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Queen whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperQueen {}
}

namespace App\Models{
/**
 * App\Models\Rook
 *
 * @property int $id
 * @property string $type
 * @property int $positionX
 * @property int $positionY
 * @property int $player_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game|null $game
 * @property-read mixed $color_param
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Move[] $moves
 * @property-read int|null $moves_count
 * @property-read \App\Models\Player $player
 * @method static \Database\Factories\RookFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Rook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rook query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rook wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rook wherePositionX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rook wherePositionY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rook whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rook whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperRook {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

