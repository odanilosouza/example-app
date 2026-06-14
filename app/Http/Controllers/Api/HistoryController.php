<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class HistoryController extends ApiController
{
    public function index(Request $request)
    {
        $clientId = $request->user()->client_id;

        $documents = $request->user()->hasRole('Cliente')
            ? $request->user()->client->documents()->latest()->get()
            : [];

        $reports = $request->user()->hasRole('Cliente')
            ? $request->user()->client->reports()->latest()->get()
            : [];

        $images = $request->user()->hasRole('Cliente')
            ? $request->user()->client->images()->latest()->get()
            : [];

        $visitReports = $request->user()->hasRole('Cliente')
            ? $request->user()->client->visitReports()->latest()->get()
            : [];

        return $this->success([
            'documents' => $documents,
            'reports' => $reports,
            'images' => $images,
            'visit_reports' => $visitReports,
        ]);
    }
}
