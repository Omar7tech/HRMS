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
    public function boot(Gate $gate)
    {


        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('moderator', function ($user) {
            return $user->role === 'moderator';
        });
    }
}
