<?php

namespace Lee2son\RedisEx\Connections;

use Lee2son\RedisEx\MutexLock;
use Lee2son\RedisEx\SpinLock;

/**
 * @mixin \Predis\Client
 */
class PredisConnection extends \Illuminate\Redis\Connections\PredisConnection
{
    use SpinLock, MutexLock;

    public function setIfNotExists(string $key, string $value, int $expire)
    {
        return $this->set($key, $value, 'EX', $expire, 'NX');
    }
}