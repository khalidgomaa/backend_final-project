<?php
namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\DoctorPolicy;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Doctor::class=>DoctorPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('is-admin', function(User $user){
            return $user->role == "admin";
        });

        Gate::define('is-client', function(User $user){
            return $user->role == "client";
        });

        Gate::define('is-owner', function(User $user){
            return $user->role == "owner";
        });
    }
}
