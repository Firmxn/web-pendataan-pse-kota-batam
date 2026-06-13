<?php

namespace App\Providers;

use App\Models\HostingRequest;
use App\Models\Opd;
use App\Models\Pse;
use App\Models\SubdomainRequest;
use App\Models\User;
use App\Policies\HostingRequestPolicy;
use App\Policies\OpdPolicy;
use App\Policies\PsePolicy;
use App\Policies\SubdomainRequestPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Pse::class => PsePolicy::class,
        SubdomainRequest::class => SubdomainRequestPolicy::class,
        HostingRequest::class => HostingRequestPolicy::class,
        Opd::class => OpdPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
