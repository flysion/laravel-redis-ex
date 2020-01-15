# laravel-redis-ex
对 redis 进行扩展

## 特性
1. 支持自定义扩展

    自定义方法：
    
        namespace App;
        
        use Predis\Client as PredisClient;
        use RedisCluster;
        
        class Redis extends PredisClient /* 如果你使用的是 phpredis 需要继承自 RedisCluster */
        {
            // add costom method ...
            public function test()
            {
            
            }
        }

    注册自定义`client`在`App\Providers\AppServiceProvider::register`中：
    
        // 如果你使用的是 predis
        \Lee2son\RedisEx\Connectors\PredisConnector::$clientClass = \App\Redis::class
        
        // 如果你使用的是 phpredis
        \Lee2son\RedisEx\Connectors\PhpRedisConnector::$clientClass = \App\Redis::class
        
    使用：
    
        \Illuminate\Support\Facades\Redis::test()
        
        // or
        \Illuminate\Support\Facades\Redis::connection('default')->test()
        

2. 增加`互斥锁`和`自旋锁`

        \Illuminate\Support\Facades\Redis::spinLock('lock_key', function() {

        });

        \Illuminate\Support\Facades\Redis::mutexLock('lock_key', function() {

        });