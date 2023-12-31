<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffsetLimitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'limit' => ['required', 'integer'],
            'offset' => ['required', 'integer'],
        ];
    }
}
