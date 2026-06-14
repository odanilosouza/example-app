<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\VisitReport\StoreVisitReportRequest;
use App\Models\VisitReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitReportController extends ApiController
{
    public function index(Request $request)
    {
        $query = VisitReport::with('client');

        if ($request->user()->hasRole('Cliente')) {
            $query->where('client_id', $request->user()->client_id);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $visitReports = $query->paginate(20);

        return $this->success(['visit_reports' => $visitReports]);
    }

    public function store(StoreVisitReportRequest $request)
    {
        $data = $request->validated();

        $visitReport = VisitReport::create([
            'client_id' => $data['client_id'],
            'technician_id' => $data['technician_id'] ?? null,
            'visit_date' => $data['visit_date'],
            'observations' => $data['observations'] ?? null,
            'equipment_evaluated' => $data['equipment_evaluated'] ?? null,
        ]);

        if ($request->hasFile('pdf')) {
            $visitReport->addMediaFromRequest('pdf')->toMediaCollection('visit_reports');
        }

        return $this->success(['visit_report' => $visitReport], 'Ficha de visita registrada.', 201);
    }

    public function show(VisitReport $visitReport)
    {
        $this->authorize('view', $visitReport);

        return $this->success(['visit_report' => $visitReport]);
    }

    public function destroy(VisitReport $visitReport)
    {
        $this->authorize('delete', $visitReport);

        $visitReport->delete();

        return $this->success([], 'Ficha de visita removida.');
    }

    public function download(Request $request, VisitReport $visitReport)
    {
        $this->authorize('view', $visitReport);

        $media = $visitReport->getFirstMedia('visit_reports');

        if (! $media) {
            return $this->error('Arquivo não encontrado.', 404);
        }

        $request->user()->downloads()->create([
            'client_id' => $visitReport->client_id,
            'subject_type' => VisitReport::class,
            'subject_id' => $visitReport->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return Storage::disk($media->disk)->download($media->getPath(), $media->file_name);
    }
}
