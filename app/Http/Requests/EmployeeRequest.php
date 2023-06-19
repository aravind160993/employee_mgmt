<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        $employee_token = $this->route('token')? $this->route('token') : null;

        return [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'profile' => 'required|max:255',
            'mobile' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique('employees', 'mobile')->where(function ($query) use($employee_token) {
                    return $query->where('token', "!=", $employee_token);
                }),
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('employees', 'email')->where(function ($query) use($employee_token) {
                    return $query->where('token', "!=", $employee_token);
                }),
            ],
            'blood_group' => 'required',
            'date_of_birth' => 'required|date',
            'address' => 'required|max:255',
            'department_token' => 'required|exists:departments,token',
        ];
    }

    // /** Determine if the user is authorized to make this request */
    // public function authorize(): bool
    // {
    //     return false;
    // }
}
