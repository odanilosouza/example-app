<?php

namespace App\Repositories;

use App\Models\VisitReport;

class VisitReportRepository extends BaseRepository
{
    public function __construct(VisitReport $model)
    {
        parent::__construct($model);
    }

    public function forClient(int $clientId)
    {
        return $this->model->where('client_id', $clientId);
    }
}
