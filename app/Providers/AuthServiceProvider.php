<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
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
        
        // $this->registerPolicies();

        Gate::define('is_admin',function(User $user){
            return $user->role == "admin";
        });

        Gate::define('is_owner',function(User $user ){
            return $user->role == "owner";
        });
        Gate::define('is_client',function(User $user){
            return $user->role == "client";
        });
    }
}
