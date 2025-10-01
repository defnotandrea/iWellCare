<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

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
        // Custom authentication using username
        Auth::provider('username', function ($app, array $config) {
            return new \Illuminate\Auth\EloquentUserProvider(
                $app['hash'],
                $config['model']
            );
        });

        // Override the default authentication to use username
        Auth::extend('username', function ($app, $name, array $config) {
            return new \Illuminate\Auth\SessionGuard(
                $name,
                Auth::createUserProvider($config['provider']),
                $app['session.store']
            );
        });
    }
}
