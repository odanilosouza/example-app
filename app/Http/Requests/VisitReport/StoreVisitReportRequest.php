<?php

namespace App\Http\Requests\VisitReport;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage visit reports');
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'technician_id' => ['nullable', 'exists:users,id'],
            'visit_date' => ['required', 'date'],
            'observations' => ['nullable', 'string', 'max:4000'],
            'equipment_evaluated' => ['nullable', 'array'],
            'equipment_evaluated.*.name' => ['required_with:equipment_evaluated', 'string'],
            'equipment_evaluated.*.status' => ['required_with:equipment_evaluated', 'string'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }
}
