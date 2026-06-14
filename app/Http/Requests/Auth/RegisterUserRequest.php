<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:150'],
            'company_name' => ['required', 'string', 'max:200'],
            'cnpj' => ['required', 'string', 'max:20', Rule::unique('clients', 'cnpj')],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ];
    }
}
