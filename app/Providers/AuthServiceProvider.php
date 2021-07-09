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
    {
        //Я не помню было ли это тут или нет. IDE думает что тут ошибка, но вроде бы оно тут должно быть, так что не трогаю пока
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        //register policies and permissions
        $this->registerPolicies();
        $this->defineAdmin();
        //а это я вынесу всё в логику системы распределения прав доступа. пока тут для теста. ну и чтобы тут было 4 вгп
        Gate::define('create-App\Models\Book', function (User $user){
            if($user){
                return true;
            }
        });
        Gate::define('update-App\Models\Book', function (User $user){
            if($user){
                return true;
            }
        });
        Gate::define('delete-App\Models\Book', function (User $user){
            if($user){
                return true;
            }
        });
    }
    /**
     * Grant all privileges for admin
     * @return bool|null
     */
    private function defineAdmin(): ?bool
    {
        Gate::before(function($user) {
            //return ($user->hasRole('admin') ? true : null);
        });
        return null;
    }
}
