<?php

namespace Mayoz\Tests\Categorizable;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom([
            __DIR__.'/migrations',
            __DIR__.'/../database/migrations',
        ]);
    }
}
