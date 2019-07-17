<?php

namespace Squadron\FileUploads;

use Illuminate\Support\Facades\Gate;
use Squadron\FileUploads\Models\UploadedFile;
use Squadron\FileUploads\Policies\UploadedFilePolicy;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole())
        {
            $this->publishes([
                __DIR__.'/../resources/lang/' => resource_path('lang/vendor/squadron.fileUploads'),
            ], 'lang');

            $this->publishes([
                __DIR__.'/../config/fileUploads.php' => config_path('squadron/fileUploads.php'),
            ], 'config');

            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'squadron.fileUploads');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        Gate::policy(UploadedFile::class, UploadedFilePolicy::class);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/fileUploads.php', 'squadron.fileUploads');
    }
}
