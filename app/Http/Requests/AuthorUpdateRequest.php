<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateRequest extends FormRequest
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
            'name'=>'required|string|max:50',
            'surname'=>'required|string|max:50',
            'middle_name'=>'string|max:50',
            'birth_date'=>'date_format:"Y-m-d"|nullable',
            'death_date'=>'date_format:"Y-m-d"|nullable'
        ];
    }
}
