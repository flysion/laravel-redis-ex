<?php

namespace Lee2son\RedisEx\Connectors;

use RedisCluster;

class PhpRedisConnector extends \Illuminate\Redis\Connectors\PhpRedisConnector
{
    /**
     * @var string
     */
    public static $clientClass = RedisCluster::class;

    /**
     * Create a new redis cluster instance.
     *
     * @param  array  $servers
     * @param  array  $options
     * @return \RedisCluster
     */
    protected function createRedisClusterInstance(array $servers, array $options)
    {
        if (version_compare(phpversion('redis'), '4.3.0', '>=')) {
            return new static::$clientClass(
                null,
                array_values($servers),
                $options['timeout'] ?? 0,
                $options['read_timeout'] ?? 0,
                isset($options['persistent']) && $options['persistent'],
                $options['password'] ?? null
            );
        }

        return new static::$clientClass(
            null,
            array_values($servers),
            $options['timeout'] ?? 0,
            $options['read_timeout'] ?? 0,
            isset($options['persistent']) && $options['persistent']
        );
    }
}