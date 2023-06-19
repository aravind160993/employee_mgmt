<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        $department_token = $this->route('token')? $this->route('token') : null;

        return [
            'name' => [
                'required',
                'regex:/^[a-zA-Z\s]+$/',
                'max:255',
                Rule::unique('departments', 'name')->where(function ($query) use($department_token) {
                    return $query->where('token', "!=", $department_token)
                    ->orWhereNull('token');
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'The department name already exists.',
        ];
    }

    // /** Determine if the user is authorized to make this request */
    // public function authorize(): bool
    // {
    //     return false;
    // }
}
