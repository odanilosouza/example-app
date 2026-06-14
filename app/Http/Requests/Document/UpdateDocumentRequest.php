<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage documents');
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:200'],
            'category' => ['sometimes', 'required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
            'reference_year' => ['nullable', 'integer', 'digits:4'],
            'file' => ['nullable', 'file', 'mimes:pdf,xlsx,docx,zip', 'max:10240'],
        ];
    }
}
