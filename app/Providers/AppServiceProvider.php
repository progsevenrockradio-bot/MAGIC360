<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
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
        // Auto-setup SQLite database file and migrate/seed if needed in production/cloud environments
        try {
            if (Config::get('database.default') === 'sqlite') {
                $dbPath = Config::get('database.connections.sqlite.database');
                if ($dbPath && ! file_exists($dbPath) && str_contains($dbPath, '.sqlite')) {
                    $dir = dirname($dbPath);
                    if (! is_dir($dir)) {
                        @mkdir($dir, 0755, true);
                    }
                    @touch($dbPath);
                }
            }

            if (! Schema::hasTable('ajustes')) {
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            // Silently continue if database is already configured or managed
        }
    }
}
