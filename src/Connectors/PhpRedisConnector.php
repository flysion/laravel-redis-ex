<?php

namespace Lee2son\RedisEx\Connectors;

use Illuminate\Support\Arr;
use Lee2son\RedisEx\Connections\PhpRedisClusterConnection;
use Lee2son\RedisEx\Connections\PhpRedisConnection;

class PhpRedisConnector extends \Illuminate\Redis\Connectors\PhpRedisConnector
{
    /**
     * @var string PhpRedisConnection class name
     */
    public static $phpRedisConnectionClass = PhpRedisConnection::class;

    /**
     * @var string PhpRedisClusterConnection class name
     */
    public static $phpRedisClusterConnectionClass = PhpRedisClusterConnection::class;

    /**
     * Create a new clustered PhpRedis connection.
     *
     * @param  array  $config
     * @param  array  $options
     * @return \Illuminate\Redis\Connections\PhpRedisConnection
     */
    public function connect(array $config, array $options)
    {
        return new static::$phpRedisConnectionClass($this->createClient(array_merge(
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

        return new static::$phpRedisClusterConnectionClass($this->createRedisClusterInstance(
            array_map([$this, 'buildClusterConnectionString'], $config), $options
        ));
    }
}