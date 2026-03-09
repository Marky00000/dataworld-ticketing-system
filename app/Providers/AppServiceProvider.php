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
        
        // Set Carbon timezone to match app
        Carbon::setLocale(config('app.locale'));
        date_default_timezone_set(config('app.timezone'));
        
        try {
            $mysqlNow = DB::select('SELECT NOW() as now')[0]->now;
            $carbonNow = Carbon::parse($mysqlNow);
            
            // Only set test time if MySQL time is significantly different
            if (abs($carbonNow->diffInSeconds(now())) > 2) {
                Carbon::setTestNow($carbonNow);
                
                \Log::info('Carbon synced with MySQL time', [
                    'mysql_time' => $mysqlNow,
                    'previous_app_time' => now()->format('Y-m-d H:i:s'),
                    'new_app_time' => $carbonNow->format('Y-m-d H:i:s')
                ]);
            }
        } catch (\Exception $e) {
            // Log but don't fail if MySQL query fails
            \Log::warning('Could not sync time with MySQL', [
                'error' => $e->getMessage()
            ]);
        }
    }
}