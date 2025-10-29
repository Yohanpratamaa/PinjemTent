<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AdminNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share unread notifications count with admin layout
        View::composer('components.layouts.admin', function ($view) {
            if (Auth::check() && Auth::user()->role === 'admin') {
                $unreadNotificationsCount = Notification::forAdmin()->unread()->count();
                $view->with('unreadNotificationsCount', $unreadNotificationsCount);
            }
        });
    }
}
