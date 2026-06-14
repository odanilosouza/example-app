<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository extends BaseRepository
{
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }

    public function paginateForClient($clientId, int $perPage = 20)
    {
        return $this->model->where('id', $clientId)->paginate($perPage);
    }
}
