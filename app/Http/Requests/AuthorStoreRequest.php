<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed $name
 * @property mixed $surname
 * @property mixed $middle_name
 * @property mixed $birth_date
 * @property mixed $death_date
 */
class AuthorStoreRequest extends FormRequest
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
            'middle_name'=>'string|max:50|nullable',
            'birth_date'=>'date_format:"Y-m-d"|nullable',
            'death_date'=>'date_format:"Y-m-d"|nullable'
        ];
    }
}
