<?php

use Philasearch\Cache\Providers\Redis\Objects\Tree\AddressBook;
use Philasearch\Cache\Providers\Redis\RedisClient;

class AddressBookTest extends TestCase
{
    public function testAdd ()
    {
        $this->addressBook->add("test_key", "id", [0]);
        $this->assertEquals('[0]', $this->client->getHashValue("test_key", "id"));
    }

    public function testGet ()
    {
        $this->addressBook->add("test_key", "id", [0, 1]);
        $this->assertEquals([0, 1], $this->addressBook->get("test_key", "id"));
    }
}
