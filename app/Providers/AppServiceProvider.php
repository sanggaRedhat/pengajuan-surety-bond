<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // foreach (Role::all() as $item) {
        //     Gate::define('is-'.$item->name, function ($user) use ($item){
        //         return $user->hasRole($item->name);
        //     });
        // }
    }
}
