<?php

namespace Lee2son\RedisEx\Connectors;

use Lee2son\RedisEx\Connections\PredisClusterConnection;
use Lee2son\RedisEx\Connections\PredisConnection;
use Illuminate\Contracts\Redis\Connector;
use Illuminate\Support\Arr;
use Predis\Client;

/**
 * Class PredisConnector
 * @package Lee2son\RedisEx\Connectors
 * @see \Illuminate\Redis\Connectors\PredisConnector
 */
class PredisConnector implements Connector
{
    /**
     * @var string PredisConnection class name
     */
    public static $predisConnectionClass = PredisConnection::class;

    /**
     * @var string PredisClusterConnection class name
     */
    public static $predisClusterConnectionClass = PredisClusterConnection::class;

    /**
     * Create a new clustered Predis connection.
     *
     * @param  array  $config
     * @param  array  $options
     * @return PredisConnection
     */
    public function connect(array $config, array $options)
    {
        $formattedOptions = array_merge(
            ['timeout' => 10.0], $options, Arr::pull($config, 'options', [])
        );

        return new static::$predisConnectionClass(new Client($config, $formattedOptions));
    }

    /**
     * Create a new clustered Predis connection.
     *
     * @param  array  $config
     * @param  array  $clusterOptions
     * @param  array  $options
     * @return PredisClusterConnection
     */
    public function connectToCluster(array $config, array $clusterOptions, array $options)
    {
        $clusterSpecificOptions = Arr::pull($config, 'options', []);

        return new static::$predisClusterConnectionClass(new Client(array_values($config), array_merge(
            $options, $clusterOptions, $clusterSpecificOptions
        )));
    }
}