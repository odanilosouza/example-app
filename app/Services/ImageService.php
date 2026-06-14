<?php

namespace App\Services;

use App\Models\Image;
use App\Repositories\ImageRepository;

class ImageService
{
    public function __construct(protected ImageRepository $repository)
    {
    }

    public function create(array $data): Image
    {
        return $this->repository->create($data);
    }
}
