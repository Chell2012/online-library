<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublisherSearchRequest extends FormRequest
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
            'title'=>'string|max:255|nullable',
            'approved'=>'array|nullable',
            'approved.*'=>'int|nullable',
            'pagination'=>'nullable|boolean',
            'return_json'=>'nullable|boolean',
        ];
    }
}
