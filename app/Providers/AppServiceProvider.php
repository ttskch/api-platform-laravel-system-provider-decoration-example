<?php

namespace App\Providers;

use ApiPlatform\State\Processor\WriteProcessor;
use App\State\AppWriteProcessor;
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
        //

        // $this->app->tag(AppWriteProcessor::class, ProcessorInterface::class);

        $this->app->extend(WriteProcessor::class, function (WriteProcessor $inner) {
            return new AppWriteProcessor($inner);
        });
    }
}
