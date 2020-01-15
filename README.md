# laravel-redis-ex
对 redis 进行扩展

## 自旋锁

    \Illuminate\Support\Facades\Redis::spinLock('lock_key', function() {

    });

## 互斥锁

    \Illuminate\Support\Facades\Redis::mutexLock('lock_key', function() {

    });