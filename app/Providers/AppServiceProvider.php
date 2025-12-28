<?php

namespace App\Providers;

use App\Models\ProductCart;
use Illuminate\Auth\Events\Login;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
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
        Paginator::useBootstrapFive();
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $cartCount = ProductCart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cartCount = 0;
        }
        $view->with('globalCartCount', $cartCount);
    });
// Clear their previous "stale" cart, when user login in again
    Event::listen(Login::class, function ($event) {
            ProductCart::where('user_id', $event->user->id)->delete();
        });
    }
}
