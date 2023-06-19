<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->is('api/register')) {
            return [
                'name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required|min:8',
            ];
        }

        if ($this->is('api/login')) {
            return [
                'email' => 'required|email:rfc,dns',
                'password' => 'required|min:8',
            ];
        }

        return [];
    }

    // /**
    //  * Determine if the user is authorized to make this request.
    //  */
    // public function authorize(): bool
    // {
    //     return false;
    // }
}
