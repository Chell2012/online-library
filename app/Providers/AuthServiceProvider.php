<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {   //register policies and permissions
        $this->defineAdmin();
        $this->registerPolicies();
        
        //Я не помню было ли это тут или нет. IDE думает что тут ошибка, но вроде бы оно тут должно быть, так что не трогаю пока
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        
    }
    /**
     * Grant all privileges for admin
     * @return bool|null
     */
    private function defineAdmin(): ?bool
    {
        Gate::before(function(User $user) {
            return ($user->hasRole('admin') ? true : null);
        });
        return null;
    }
}
