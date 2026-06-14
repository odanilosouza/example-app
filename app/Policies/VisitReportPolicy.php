<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VisitReport;

class VisitReportPolicy
{
    public function view(User $user, VisitReport $visitReport): bool
    {
        return $user->hasAnyRole(['Administrador', 'Master']) || $user->client_id === $visitReport->client_id;
    }

    public function delete(User $user, VisitReport $visitReport): bool
    {
        return $user->hasAnyRole(['Administrador', 'Master']);
    }
}
