<?php

use Carbon\Carbon;
use App\Models\ProductCart;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    ProductCart::where('updated_at', '<', Carbon::now()->subMinutes(1))
        ->delete();
})->hourly();