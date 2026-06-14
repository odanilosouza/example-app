<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Document;
use App\Models\Image;
use App\Models\Report;
use App\Models\VisitReport;
use App\Policies\ClientPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\ImagePolicy;
use App\Policies\ReportPolicy;
use App\Policies\VisitReportPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Client::class => ClientPolicy::class,
        Document::class => DocumentPolicy::class,
        Image::class => ImagePolicy::class,
        Report::class => ReportPolicy::class,
        VisitReport::class => VisitReportPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('manage documents', fn ($user) => $user->hasAnyRole(['Administrador', 'Master']));
        Gate::define('manage reports', fn ($user) => $user->hasAnyRole(['Administrador', 'Master']));
        Gate::define('manage images', fn ($user) => $user->hasAnyRole(['Administrador', 'Master']));
        Gate::define('manage visit reports', fn ($user) => $user->hasAnyRole(['Administrador', 'Master']));
    }
}
