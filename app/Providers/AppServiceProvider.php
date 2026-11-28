<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
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
        \Illuminate\Support\Facades\Gate::define('verify-payments', fn ($user) =>
            $user->is_active && DB::table('user_roles')->where('role_id', $user->role_id)
                ->where('role_name', 'admin')->exists());

        View::composer('layouts.admin', function ($view) {
            $view->with('notifications', DB::table('admin_notifications')
                ->latest('id')->limit(10)->get(['message', 'created_at']));
        });
    }
}
