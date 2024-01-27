<?php

namespace App\Http\Requests;

use App\Support\CurrentPlayer\CurrentPlayer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
                if (!in_array([$this->request->get('positionX'), $this->request->get('positionY')], $this->piece->availableMoves())) {
                    $validator->errors()->add('position', 'Invalid move');
                }
            }
        ];
    }
}
