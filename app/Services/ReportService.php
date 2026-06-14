<?php

namespace App\Services;

use App\Models\Report;
use App\Repositories\ReportRepository;

class ReportService
{
    public function __construct(protected ReportRepository $repository)
    {
    }

    public function create(array $data): Report
    {
        return $this->repository->create($data);
    }
}
