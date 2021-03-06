<?php

use Philasearch\Cache\Providers\Redis\RedisClient;

class ClientTest extends TestCase
{
    public function testGetSet ()
    {
        $this->client->set('foo_key', 'foo_value');
        $result = $this->client->expire('foo_key', 1);
        $this->assertTrue($result);

        $this->assertEquals('foo_value', $this->client->get('foo_key'));
    }

    public function testHashKeys ()
    {
        $this->client->setHashValue('hashFoo', 'bar', 'foo bar');
        $keys = $this->client->getHashKeys('hashFoo');

        $this->assertEquals(['bar'], $keys);
    }

    public function testExpire ()
    {
        $result = $this->client->expire('foo_key', 1);
        $this->assertFalse($result);

        $this->client->set('foo_key', 'foo_value');
        $result = $this->client->expire('foo_key', 1);
        $this->assertTrue($result);
    }

    public function testClearingOfDatabase ()
    {
        $this->client->set('foo_key', 'foo_value');
        $this->assertEquals('foo_value', $this->client->get('foo_key'));
        $this->client->clear();
        $this->assertEquals(null, $this->client->get('foo_key'));
    }

    public function testIncrement ()
    {
        $this->client->set('user:id', 1000);
        $this->assertEquals(1001, $this->client->increment('user:id'));
    }

    public function testIncrementHashKey ()
    {
        $this->client->setHashValue( 'user:id', 'counter', 1000);
        $this->assertEquals(1001, $this->client->incrementHashKey('user:id', 'counter'));
        $this->assertEquals(1011, $this->client->incrementHashKey('user:id', 'counter', 10));
    }

    public function testGetConnectionString ()
    {
        $client = new RedisClient();
        $this->assertEquals('tcp://127.0.0.1:6379?database=0', $client->getConnectionStrings());

        $client = new RedisClient('tcp://1.1.1.1:1234?database=42');
        $this->assertEquals('tcp://1.1.1.1:1234?database=42', $client->getConnectionStrings());
    }
}
