<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ["required"],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', "min:8", 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }
}
