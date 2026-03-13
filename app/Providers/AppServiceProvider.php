<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
    Vite::prefetch(concurrency: 3);
    
    // Force HTTPS in production
    if (env('APP_ENV') === 'production') {
        URL::forceScheme('https');
    }
    
    try {
    $mysqlNow = DB::select('SELECT NOW() as now')[0]->now;
    $carbonNow = Carbon::parse($mysqlNow);
    
    // Log the difference but DON'T freeze time
    if (abs($carbonNow->diffInSeconds(now())) > 2) {
        \Log::info('MySQL time differs from app time', [
            'mysql_time' => $mysqlNow,
            'app_time' => now()->format('Y-m-d H:i:s'),
            'difference_seconds' => $carbonNow->diffInSeconds(now())
        ]);
    }
} catch (\Exception $e) {
    \Log::warning('Could not check MySQL time', [
        'error' => $e->getMessage()
    ]);
}
    
   
}
}