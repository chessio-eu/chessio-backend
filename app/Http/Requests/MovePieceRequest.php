<?php

namespace App\Http\Requests;

use App\Models\Piece;
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

    public function withValidator(Validator $validator) {
        if (!in_array([$this->request->get('positionX'), $this->request->get('positionY')], $this->piece->availableMoves())) {
            $validator->errors()->add('position', 'Invalid move');
        }
    }
}
