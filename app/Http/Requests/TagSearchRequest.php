<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $title
 * @property int $category_id
 * @property int $approved
 * @property bool $pagination
 * @property bool $return_json
 */
class TagSearchRequest extends FormRequest
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
            'title'=>'string|max:255|nullable',
            'category_id' => 'nullable|integer|exists:App\Models\Category,id',
            'approved'=>'array|nullable',
            'approved.*'=>'int|nullable',
            'pagination'=>'nullable|boolean',
            'return_json'=>'nullable|boolean',
        ];
    }
}
