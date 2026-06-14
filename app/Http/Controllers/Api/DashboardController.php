<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\AuditLog;
use App\Models\Client;
use App\Models\Document;
use App\Models\Image;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
    public function client(Request $request)
    {
        $client = $request->user()->client;

        return $this->success([
            'totals' => [
                'documents' => $client->documents()->count(),
                'reports' => $client->reports()->count(),
                'images' => $client->images()->count(),
                'visit_reports' => $client->visitReports()->count(),
                'notifications' => $request->user()->notifications()->count(),
            ],
        ]);
    }

    public function admin()
    {
        $totalClients = Client::count();
        $totalUsers = User::count();
        $totalDocuments = Document::count();
        $totalReports = Report::count();
        $totalImages = Image::count();
        $pendingRequests = Client::where('status', 'pendente')->count();

        return $this->success([
            'totals' => compact('totalClients', 'totalUsers', 'totalDocuments', 'totalReports', 'totalImages', 'pendingRequests'),
        ]);
    }
}
