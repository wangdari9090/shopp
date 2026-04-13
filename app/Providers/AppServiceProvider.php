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

        // Clear stale carts (those inactive for > 5 minutes)
        // This ensures the logic works even without a background scheduler
        $threshold = now()->subMinutes(5)->timestamp;
        
        \App\Models\ProductCart::whereIn('user_id', function ($query) use ($threshold) {
            $query->select('id')
                ->from('users')
                ->whereNotExists(function ($subQuery) use ($threshold) {
                    $subQuery->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('sessions')
                        ->whereColumn('sessions.user_id', 'users.id')
                        ->where('last_activity', '>=', $threshold);
                });
        })->delete();

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cartCount = ProductCart::where('user_id', Auth::id())->sum('quantity');
            } else {
                $cartCount = 0;
            }
            $view->with('globalCartCount', $cartCount);
        });

        // Clear their previous "stale" cart, when user login in again
        // Event::listen(Login::class, function ($event) {
        //         ProductCart::where('user_id', $event->user->id)->delete();
        //     });
    }
}
