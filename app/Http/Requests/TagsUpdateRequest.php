<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

/**
 * @property string $title
 * @property int $category_id
 */
class TagsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>[
                'required',
                'string',
                Rule::unique('App\Models\Tag', 'title')->ignore($this->tag),
                'max:255'
            ],
            'category_id' => 'nullable|integer|exists:App\Models\Category,id'
        ];
    }
}
