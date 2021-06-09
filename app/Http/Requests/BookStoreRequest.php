<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
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
            'publisher_id'=> 'required|integer|exists:App\Models\Publisher,id',
            'year'=>'integer|required|max:'.date("Y"),
            'isbn'=>'string|nullable|max:17',//TODO: поправить в бд. сделать nullable 
            'category_id'=> 'nullable|integer|exists:App\Models\Category,id',
            'link'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'tag_id'=>'array|nullable',
            'tag_id.*'=>'integer|exists:App\Models\Tag,id',
            'author_id'=>'array|nullable',
            'author_id.*'=>'integer|exists:App\Models\Author,id'
        ];
    }
}
