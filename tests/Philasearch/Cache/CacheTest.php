<?php

use Philasearch\Cache\Cache;

class CacheTest extends TestCase
{
    public function testCacheSetup ()
    {
        Cache::setup(\Philasearch\Cache\CacheProviders::REDIS);

        $this->assertEquals(\Philasearch\Cache\CacheProviders::REDIS, Cache::currentCache());
    }
}