<?php

namespace App\Http\Requests\API\Companies;

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
            'name'  => 'required|string|max:255',
            'owner_name'  => 'required|string|max:255',
            'type'  => 'required|integer|min:1',
            'establish_date'  => 'required|date',
            'logo'  => 'nullable|sometimes|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }
}
