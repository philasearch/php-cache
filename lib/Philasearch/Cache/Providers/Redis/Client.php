<?php

/**
 * Client.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache\Providers\Redis;

use Predis\Client as RedisClient;

/**
 * Class Client
 *
 * Redis client
 *
 * @package Philasearch\Cache\Providers\Redis
 *
 */
class Client
{
    private static $redis   = null;
    private static $config  = [];
    private static $options = [];

    /**
     * Configures the Redis Client
     *
     * @param array $config
     *
     */
    public static function setup ( $config=null, $options=[] )
    {
        if ( !$config )
            self::$config = 'tcp://127.0.0.1:6379?database=0';

        return self::connect();
    }

    /**
     * Expires a key in redis after a set time
     *
     * @param string    $key    The key in redis
     * @param integer   $time   The time to expire
     */
    public function expire ( $key, $time )
    {
        return self::redisFunction( 'expire', $key, $time );
    }

    /**
     * Gets the value from the redis store
     *
     * @param $key
     */
    public static function get ( $key )
    {
        return self::redisFunction( 'get', $key );
    }

    /**
     * Gets a hash value from the redis store
     *
     * @param $key
     * @param $field
     *
     * @return mixed
     */
    public static function hget ( $key, $field )
    {
        $return = self::redisFunction( 'hget', $key, $field );

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
    public static function hset ( $key, $field, $value )
    {
        return self::redisFunction( 'hset', $key, $field, $value );
    }

    /**
     * Gets all the hash values from the redis store
     *
     * @param $key
     *
     * @return mixed
     */
    public static function hgetall ( $key )
    {
        return self::redisFunction( 'hgetall', $key );
    }

    /**
     * Deletes a hash value from the redis store
     *
     * @param $key
     * @param $field
     *
     * @return mixed
     */
    public static function hdel ( $key, $field )
    {
        return self::redisFunction( 'hdel', $key, $field );
    }

    /**
     * Sets a value in the redis store
     *
     * @param $key
     * @param $value
     */
    public static function set ( $key, $value )
    {
        return self::redisFunction( 'set', $key, $value );
    }

    /**
     * Clears the redis database
     */
    public static function clear ()
    {
        return self::redisFunction( 'flushdb' );
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
            self::$redis = new RedisClient( self::$config, self::$options );

            try
            {
                self::$redis->connect();
            }
            catch ( \Predis\Connection\ConnectionException $e )
            {
                self::$redis = null;
                return false;
            }
        }

        return self::$redis;
    }

    public static function redisFunction ()
    {
        $redis      = self::connect();
        $args       = func_get_args();
        $function   = array_shift( $args );

        if ( $redis )
        {
            try
            {
                return call_user_func_array( array($redis, $function), $args );
            }
            catch ( \Predis\ServerException $e )
            {
                throw new Exceptions\CommandException( $function, $args );
            }
        }
        else
        {
            throw new Exceptions\ConnectionException();
        }

        return false;
    }
}
