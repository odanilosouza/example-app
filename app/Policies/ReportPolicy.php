<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    public function view(User $user, Report $report): bool
    {
        return $user->hasAnyRole(['Administrador', 'Master']) || $user->client_id === $report->client_id;
    }

    public function delete(User $user, Report $report): bool
    {
        return $user->hasAnyRole(['Administrador', 'Master']);
    }
}
