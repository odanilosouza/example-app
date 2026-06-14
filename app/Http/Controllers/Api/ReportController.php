<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Report\StoreReportRequest;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends ApiController
{
    public function index(Request $request)
    {
        $query = Report::with('client');

        if ($request->user()->hasRole('Cliente')) {
            $query->where('client_id', $request->user()->client_id);
        }

        if ($request->filled('report_type')) {
            $query->where('report_type', $request->report_type);
        }

        $reports = $query->paginate(20);

        return $this->success(['reports' => $reports]);
    }

    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();

        $report = Report::create([
            'client_id' => $data['client_id'],
            'uploaded_by' => $request->user()->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'report_type' => $data['report_type'],
            'reference_date' => $data['reference_date'],
        ]);

        $report->addMediaFromRequest('file')->toMediaCollection('reports');

        return $this->success(['report' => $report], 'Relatório enviado.', 201);
    }

    public function show(Report $report)
    {
        $this->authorize('view', $report);

        return $this->success(['report' => $report]);
    }

    public function destroy(Report $report)
    {
        $this->authorize('delete', $report);

        $report->delete();

        return $this->success([], 'Relatório removido.');
    }

    public function download(Request $request, Report $report)
    {
        $this->authorize('view', $report);

        $media = $report->getFirstMedia('reports');

        if (! $media) {
            return $this->error('Arquivo não encontrado.', 404);
        }

        $request->user()->downloads()->create([
            'client_id' => $report->client_id,
            'subject_type' => Report::class,
            'subject_id' => $report->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return Storage::disk($media->disk)->download($media->getPath(), $media->file_name);
    }
}
