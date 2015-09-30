<?php

/**
 * Cache.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache;

use Philasearch\Cache\Providers\Redis\RedisClient as RedisClient;
use Philasearch\Cache\Providers\Redis\Objects\Object as RedisObject;
use Philasearch\Cache\Providers\Redis\Objects\Tree as RedisTree;

/**
 * Class Cache
 *
 * Interacts with cache providers to create various cached objects.
 *
 * @package Philasearch\Cache
 *
 */
class Cache
{
    private static $currentCache = CacheProviders::REDIS;

    /**
     * Sets up the cache
     *
     * @param $type
     * @param null $cacheConfig
     * @param array $cacheOptions
     */
    public static function setup ( $type, $cacheConfig=null, $cacheOptions=[] )
    {
        switch ( $type )
        {
            case CacheProviders::REDIS:
                RedisClient::setup($cacheConfig, $cacheOptions);
                self::$currentCache = CacheProviders::REDIS;
                break;
            default:
                break;
        }
    }

    /**
     * Returns the current cache type
     *
     * @return int
     */
    public static function currentCache ()
    {
        return self::$currentCache;
    }

    /**
     * Creates a cached object
     *
     * @param   $key
     * @param   $type
     *
     * @param array $data
     * @param int $expire
     *
     * @return null|RedisObject
     */
    public static function object ( $key, $type, $data=[], $expire=0 )
    {
        switch ( self::$currentCache )
        {
            case CacheProviders::REDIS:
                switch ( $type )
                {
                    case ObjectType::OBJECT:
                        return new RedisObject( $key, $data, $expire );
                    case ObjectType::TREE:
                        return new RedisTree($key);
                }
                break;
        }
        return null;
    }

    /**
     * Returns a client
     *
     * @return null|RedisClient
     */
    public static function getClient ()
    {
        switch ( self::$currentCache )
        {
            case CacheProviders::REDIS:
                return new RedisClient();
                break;
        }

        return null;
    }
}
