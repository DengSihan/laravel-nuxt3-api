<?php

namespace App\Http\Requests\Auth\Tokens;

use App\Http\Requests\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string'
            ],
        ];
    }
}
