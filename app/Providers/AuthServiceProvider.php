<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        Passport::routes();

        // Check for Admin
        $gate->define('isAdmin', function ($user)
        {
            return $user->user_role == 'Admin';
        });

        // Check for project manager
        $gate->define('isProjectManager', function ($user)
        {
            return $user->user_role == 'Project Manager';
        });

        // Check for user
        $gate->define('isUser', function ($user)
        {
            return $user->user_role == 'User';
        });
    }
}
