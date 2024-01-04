<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    public function boot(): void
    {

        $this->registerPolicies();

        Gate::define('access-dashboard', function ($user) {
            return $user->hasAnyRole(['sekreterlik', 'etik_kurul', "user", "admin"]);
        });
    }
}
