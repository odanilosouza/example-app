<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\User;

class ImagePolicy
{
    public function view(User $user, Image $image): bool
    {
        return $user->hasAnyRole(['Administrador', 'Master']) || $user->client_id === $image->client_id;
    }

    public function delete(User $user, Image $image): bool
    {
        return $user->hasAnyRole(['Administrador', 'Master']);
    }
}
