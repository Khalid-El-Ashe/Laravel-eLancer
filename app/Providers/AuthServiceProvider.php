<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Category;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Category::class => CategoryPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);


        /**
         * if have an account SuperAdminstrator should not have any role
         * that mean all the time have all permissions
         */
        Gate::before(function ($user, $ability) {
            // if ($user->id == 1) {
            //     return true;
            // }

            // if ($user->type == 'super-adminstrator') {
            //     return true;
            // }
        });
        # need make a Gate for Roles

        foreach (config('abilities') as $ability => $lable) {

            Gate::define($ability, function ($user) use ($ability) {
                return $user->hasAbility($ability);
            });
        }
    }
}
