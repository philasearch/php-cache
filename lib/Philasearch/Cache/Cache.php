<?php

/**
 * Cache.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache;

use Philasearch\Cache\Providers\Base\BaseClient;
use Philasearch\Cache\Providers\Base\Objects\BaseObject;
use Philasearch\Cache\Providers\Base\Objects\BaseTree;
use Philasearch\Cache\Providers\Redis\RedisClient;

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
    /**
     * @var BaseClient
     */
    private $client = null;

    public function __construct ( $type = CacheProviders::REDIS, $connectionStrings=[], $cacheOptions = [] )
    {
        switch ( $type )
        {
            case CacheProviders::REDIS:
                $this->client = new RedisClient($connectionStrings, $cacheOptions);
                break;
            default;
                break;
        }
    }

    /**
     * Creates a cached object
     *
     * @param       $key
     * @param array $data
     * @param int   $expire
     *
     * @return BaseObject
     */
    public function createObject ( $key, $data = [], $expire = 0 )
    {
        return $this->client->createObject($key, $data, $expire);
    }

    /**
     * Creates a cached tree
     *
     * @param string $key
     * @param integer $expire
     *
     * @return BaseTree
     */
    public function createTree ( $key, $expire = 0 )
    {
        return $this->client->createTree($key, $expire);
    }

    /**
     * Returns a client
     *
     * @return BaseClient
     */
    public function getClient ()
    {
        return $this->client;
    }
}
