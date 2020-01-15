<?php

namespace Lee2son\RedisEx\Connections;

use Lee2son\RedisEx\MutexLock;
use Lee2son\RedisEx\SpinLock;

/**
 * @mixin \Redis
 */
class PhpRedisConnection extends \Illuminate\Redis\Connections\PhpRedisConnection
{
    use SpinLock, MutexLock;

    public function setIfNotExists(string $key, string $value, int $expire)
    {
        return $this->set($key, $value, 'EX', $expire, 'NX');
    }
}
