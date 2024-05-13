<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('isSuperAdmin', function ($user) {
            $allowedRoles = ['1', 1];
            return in_array($user->role, $allowedRoles);
        });

        Gate::define('isAdmin', function ($user) {
            $allowedRoles = ['2', 2];
            return in_array($user->role, $allowedRoles);
        });

        Gate::define('isUser', function ($user) {
            $allowedRoles = ['3', 3];
            return in_array($user->role, $allowedRoles);
        });
    }
}
