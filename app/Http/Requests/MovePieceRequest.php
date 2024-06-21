<?php

namespace App\Http\Requests;

use App\Models\Piece;
use App\Support\CurrentPlayer\CurrentPlayer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * @property Piece $piece
 */
class MovePieceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'positionX' => 'integer|min:0|max:7',
            'positionY' => 'integer|min:0|max:7'
        ];
    }

    public function authorize(): bool {
        $currentPlayer = app(CurrentPlayer::class)->get();

        return $currentPlayer?->id === $this->piece->player->id;
    }

    public function after(): array {
        return [
            function (Validator $validator) {
                if ($this->piece->game->playerTurn()->id !== $this->piece->player->id) {
                    $validator->errors()->add('turn', 'Not player\'s turn');
                    return;
                }

                if (!$this->piece->canMoveTo($this->input('positionX'), $this->input('positionY'))) {
                    $validator->errors()->add('position', 'Invalid move');
                }
            }
        ];
    }
}
