<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $surname
 * @property string $middle_name
 * @property Carbon $birth_date
 * @property Carbon $death_date
 * @property int $approved
 */
class AuthorSearchRequest extends FormRequest
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
            'name'=>'string|max:50|nullable',
            'surname'=>'string|max:50|nullable',
            'middle_name'=>'string|max:50|nullable',
            'birth_date'=>'date_format:"Y-m-d"|nullable',
            'death_date'=>'date_format:"Y-m-d"|nullable',
            'approved'=>'int|nullable',
        ];
    }
}
