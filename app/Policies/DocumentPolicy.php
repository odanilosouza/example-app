<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function view(User $user, Document $document): bool
    {
        return $user->hasAnyRole(['Administrador', 'Master']) || $user->client_id === $document->client_id;
    }

    public function update(User $user, Document $document): bool
    {
        return $user->hasAnyRole(['Administrador', 'Master']);
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->hasAnyRole(['Administrador', 'Master']);
    }
}
