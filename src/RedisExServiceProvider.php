<?php

namespace Lee2son\RedisEx;

use Lee2son\RedisEx\Connectors\PhpRedisConnector;
use Lee2son\RedisEx\Connectors\PredisConnector;
use Illuminate\Support\Facades\Redis;

class ExtendServiceProvider extends \Illuminate\Redis\RedisServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        Redis::extend('predis', function() {
            return new PredisConnector();
        });

        Redis::extend('phpredis', function() {
            return new PhpRedisConnector();
        });

        parent::boot();
    }

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        parent::register();
    }
}