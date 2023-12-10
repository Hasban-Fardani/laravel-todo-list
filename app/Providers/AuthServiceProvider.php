<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // register Gate
        Gate::define('edit-todo', function (User $user, Todo $todo) {
            // check todo->user_id == $user->id
            return $todo->user_id == $user->id;
        });
    }
}
