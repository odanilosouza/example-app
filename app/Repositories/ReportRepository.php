<?php

namespace App\Repositories;

use App\Models\Report;

class ReportRepository extends BaseRepository
{
    public function __construct(Report $model)
    {
        parent::__construct($model);
    }

    public function forClient(int $clientId)
    {
        return $this->model->where('client_id', $clientId);
    }
}
