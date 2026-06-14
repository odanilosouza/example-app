<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository extends BaseRepository
{
    public function __construct(Image $model)
    {
        parent::__construct($model);
    }

    public function forClient(int $clientId)
    {
        return $this->model->where('client_id', $clientId);
    }
}
