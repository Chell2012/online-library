<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'=>'nullable|string|max:100',
            'publisher_id'=> 'nullable|integer|exists:App\Models\Publisher,id',
            'year'=>'integer|nullable|max:'.date("Y"),
            'isbn'=>'string|nullable|max:17',
            'category_id'=> 'nullable|integer|exists:App\Models\Category,id',
            'tag_id'=>'array|nullable',
            'tag_id.*'=>'integer|exists:App\Models\Tag,id',
            'author_id'=>'array|nullable',
            'author_id.*'=>'integer|exists:App\Models\Author,id',
            'approved'=>'array|nullable',
            'forApproveOnly'=>'bool|nullable',
            'sortBy'=>'string|nullable'
        ];
    }
}
