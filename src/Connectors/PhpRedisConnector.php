<?php

namespace Lee2son\RedisEx\Connectors;

use Illuminate\Support\Arr;
use Lee2son\RedisEx\Connections\PhpRedisClusterConnection;
use Lee2son\RedisEx\Connections\PhpRedisConnection;
use RedisCluster;

class PhpRedisConnector extends \Illuminate\Redis\Connectors\PhpRedisConnector
{
    /**
     * @var string
     */
    public static $clientClass = RedisCluster::class;

    /**
     * Create a new clustered PhpRedis connection.
     *
     * @param  array  $config
     * @param  array  $options
     * @return \Illuminate\Redis\Connections\PhpRedisConnection
     */
    public function connect(array $config, array $options)
    {
        return new PhpRedisConnection($this->createClient(array_merge(
            $config, $options, Arr::pull($config, 'options', [])
        )));
    }

    /**
     * Create a new clustered PhpRedis connection.
     *
     * @param  array  $config
     * @param  array  $clusterOptions
     * @param  array  $options
     * @return \Illuminate\Redis\Connections\PhpRedisClusterConnection
     */
    public function connectToCluster(array $config, array $clusterOptions, array $options)
    {
        $options = array_merge($options, $clusterOptions, Arr::pull($config, 'options', []));

        return new PhpRedisClusterConnection($this->createRedisClusterInstance(
            array_map([$this, 'buildClusterConnectionString'], $config), $options
        ));
    }

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