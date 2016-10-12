<?php

namespace App\Providers;

use App\Bots\Eve;
use App\Handlers\HandlerManager;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(HandlerManager::class, function ($app) {
            $handlers = new Collection();
            
            foreach($app['config']->get('eve.handlers') as $handler) {
                $handlers->push($app->make($handler));
            }

            return HandlerManager::withHandlers($handlers);
        });

        $this->app->singleton(Eve::class, function ($app) {
            return new Eve(
                $app['config']->get('eve.auth.token'),
                $app->make(HandlerManager::class)
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
