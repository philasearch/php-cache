<?php

/**
 * Client.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache\Providers\Redis;

use Predis\Client;

/**
 * Class RedisClient
 *
 * A client for redis
 *
 * @package Philasearch\Cache\Providers\Redis
 *
 */
class RedisClient
{
    /**
     * @var Client
     */
    private static $redis = null;

    /**
     * @var array
     */
    private static $config = [];

    /**
     * @var array
     */
    private static $options = [];

    /**
     * Configures the Redis Client
     *
     * @param array $config
     * @param array $options
     *
     * @return mixed
     */
    public static function setup ( $config = null, $options = [] )
    {
        self::$config = ($config) ? $config : 'tcp://127.0.0.1:6379?database=0';
        self::$options = $options;

        return self::connect();
    }

    /**
     * Expires a key in redis after a set time
     *
     * @param string  $key  The key in redis
     * @param integer $time The time to expire
     *
     * @return mixed
     */
    public function expire ( $key, $time )
    {
        return self::redisFunction('expire', $key, $time);
    }

    /**
     * Gets the value from the redis store
     *
     * @param $key
     *
     * @return mixed
     */
    public function get ( $key )
    {
        return self::redisFunction('get', $key);
    }

    /**
     * Gets a hash value from the redis store
     *
     * @param $key
     * @param $field
     *
     * @return mixed
     */
    public function hget ( $key, $field )
    {
        $return = self::redisFunction('hget', $key, $field);

        if ( !$return )
            return [];

        return $return;
    }

    /**
     * Sets a hash value in the redis store
     *
     * @param $key
     * @param $field
     * @param $value
     *
     * @return mixed
     */
    public function hset ( $key, $field, $value )
    {
        return self::redisFunction('hset', $key, $field, $value);
    }

    /**
     * Gets all the hash values from the redis store
     *
     * @param $key
     *
     * @return mixed
     */
    public function hgetall ( $key )
    {
        return self::redisFunction('hgetall', $key);
    }

    /**
     * Deletes a hash value from the redis store
     *
     * @param $key
     * @param $field
     *
     * @return mixed
     */
    public function hdel ( $key, $field )
    {
        return self::redisFunction('hdel', $key, $field);
    }

    /**
     * Sets a value in the redis store
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set ( $key, $value )
    {
        return self::redisFunction('set', $key, $value);
    }

    /**
     * Clears the redis database
     */
    public function clear ()
    {
        return self::redisFunction('flushdb');
    }


    /**
     *  Gets all keys from the redis store matching pattern
     *
     * @param $pattern
     *
     * @return mixed
     */
    public function keys ( $pattern )
    {
        return self::redisFunction('keys', $pattern);
    }

    /**
     * Runs a redis function
     *
     * @return mixed
     *
     * @throws Exceptions\CommandException
     * @throws Exceptions\ConnectionException
     */
    private static function redisFunction ()
    {
        $redis = self::connect();
        $args = func_get_args();
        $function = array_shift($args);

        if ( $redis )
        {
            try
            {
                return call_user_func_array([$redis, $function], $args);
            } catch ( \Exception $e )
            {
                throw new Exceptions\CommandException($function, $args);
            }
        }

        throw new Exceptions\ConnectionException();
    }

    /**
     * Connects to the redis client
     *
     * @return null|RedisClient
     */
    private static function connect ()
    {
        if ( self::$config == null )
            self::setup();

        if ( self::$redis == null )
        {
            self::$redis = new Client(self::$config, self::$options);

            try
            {
                self::$redis->connect();
            } catch ( \Exception $e )
            {
                self::$redis = null;

                return false;
            }
        }

        return self::$redis;
    }
}