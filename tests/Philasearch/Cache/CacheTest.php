<?php

use Philasearch\Cache\Cache;
use Philasearch\Cache\CacheProviders;
use Philasearch\Cache\Providers\Redis\Objects\RedisObject;
use Philasearch\Cache\Providers\Redis\Objects\RedisTree;
use Philasearch\Cache\Providers\Redis\RedisClient;

class CacheTest extends TestCase
{
    /**
     * @var Cache
     */
    private $cache;

    public function setUp ()
    {
        parent::setUp();

        $this->cache = new Cache(CacheProviders::REDIS);
    }

    public function testGetObject ()
    {
        $object = $this->cache->createObject('foo');
        $this->assertNotNull($object);
        $this->assertEquals(get_class(new RedisObject($this->client, 'bar')), get_class($object));
    }

    public function testGetTree ()
    {
        $tree = $this->cache->createTree('foo');
        $this->assertNotNull($tree);
        $this->assertEquals(get_class(new RedisTree($this->client, 'bar')), get_class($tree));
    }

    public function testGetClient ()
    {
        $client = $this->cache->getClient();
        $this->assertNotNull($client);
        $this->assertEquals(get_class(new RedisClient()), get_class($client));
    }
}