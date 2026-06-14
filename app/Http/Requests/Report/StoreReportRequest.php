<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage reports');
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:2000'],
            'report_type' => ['required', 'string', 'max:100'],
            'reference_date' => ['required', 'date'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }
}
