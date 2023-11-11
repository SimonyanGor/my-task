<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostStoreRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description_am' => ['string'],
            'description_ru' => ['string'],
            'description_en' => ['string'],
            'image_url' => ['string']
        ];
    }
}
