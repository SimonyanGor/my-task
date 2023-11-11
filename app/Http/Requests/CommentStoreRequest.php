<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentStoreRequest extends FormRequest
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
            "post_id" => ["required", Rule::exists('posts', 'id')],
            "comment_am" => ['string'],
            "comment_ru" => ['string'],
            "comment_en" => ['string']
        ];
    }
}
