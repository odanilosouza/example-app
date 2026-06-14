<?php

namespace App\Services;

use App\Models\VisitReport;
use App\Repositories\VisitReportRepository;

class VisitReportService
{
    public function __construct(protected VisitReportRepository $repository)
    {
    }

    public function create(array $data): VisitReport
    {
        return $this->repository->create($data);
    }
}
