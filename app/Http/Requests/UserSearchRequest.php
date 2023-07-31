<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSearchRequest extends FormRequest
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
            'name'=>'nullable|string|max:225',
            'email'=>'nullable|email|max:225',
            'roles'=>'nullable|array',
            'roles.*'=>'string|max:225',
            'verified'=>'nullable|boolean'
        ];
    }
}
