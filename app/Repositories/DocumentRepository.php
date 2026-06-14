<?php

namespace App\Repositories;

use App\Models\Document;

class DocumentRepository extends BaseRepository
{
    public function __construct(Document $model)
    {
        parent::__construct($model);
    }

    public function forClient(int $clientId)
    {
        return $this->model->where('client_id', $clientId);
    }
}
