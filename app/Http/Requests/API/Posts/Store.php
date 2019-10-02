<?php

namespace App\Http\Requests\API\Posts;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'title'  => 'required|string|max:255',
            'type'  => 'required|integer|min:1',
            'post_date'  => 'required|date',
        ];
    }
}
