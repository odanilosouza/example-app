<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterClientRequest extends FormRequest
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
            'cnpj' => ['required', 'string', 'max:20', 'unique:client_requests,cnpj'],
            'position' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:150'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'observations' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
