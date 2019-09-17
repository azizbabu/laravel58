<?php

namespace App\Http\Requests\API\Companies;

use Illuminate\Foundation\Http\FormRequest;
use App\Company;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $company = $this->route('company');

        return $this->user()->can('update', $company);
        // return $this->user()->id === $company->user_id;
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
