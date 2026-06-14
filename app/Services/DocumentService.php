<?php

namespace App\Services;

use App\Models\Document;
use App\Repositories\DocumentRepository;

class DocumentService
{
    public function __construct(protected DocumentRepository $repository)
    {
    }

    public function create(array $data): Document
    {
        return $this->repository->create($data);
    }

    public function update(Document $document, array $data): Document
    {
        return $this->repository->update($document, $data);
    }
}
