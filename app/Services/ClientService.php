<?php

namespace App\Services;

use App\Models\Client;
use App\Repositories\ClientRepository;

class ClientService
{
    public function __construct(protected ClientRepository $repository)
    {
    }

    public function find(int $id): ?Client
    {
        return $this->repository->find($id);
    }

    public function update(Client $client, array $data): Client
    {
        return $this->repository->update($client, $data);
    }
}
