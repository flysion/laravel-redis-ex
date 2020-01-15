<?php

namespace Lee2son\RedisEx;

use Lee2son\RedisEx\Connectors\PhpRedisConnector;
use Lee2son\RedisEx\Connectors\PredisConnector;
use Illuminate\Support\Facades\Redis;

class ServiceProvider extends \Illuminate\Redis\RedisServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        parent::register();
        
        Redis::extend('predis', function() {
            return new PredisConnector();
        });

        Redis::extend('phpredis', function() {
            return new PhpRedisConnector();
        });
    }
}