<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
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
            'title'=>'required|string|max:100',
            'publisher'=> 'required|string|max:50',
            'year'=>'integer|required|max:'.date("Y"),
            'isbn'=>'string|nullable|max:17',//TODO: поправить в бд. сделать nullable 
            'category'=> 'string|max:50',//TODO: сделать значение по умолчанию и добавить nullable 
            'link'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'tags'=>'array|nullable',
            'tags.*'=>'string|max:50',
            'authors'=>'array|nullable',
            'authors.*.surname'=>'string|max:50',
            'authors.*.name'=>'string|max:50',
            'authors.*.middle_name'=>'string|nullable|max:50'
        ];
    }
}
