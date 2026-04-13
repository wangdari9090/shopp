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

        $threshold = now()->subMinutes(5)->timestamp;

        ProductCart::whereIn('user_id', function ($query) use ($threshold) {
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

    }
}
