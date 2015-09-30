<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Philasearch\Cache\Providers\Redis\Objects\Tree\AddressBook;
use Philasearch\Cache\Providers\Redis\RedisClient as RedisClient;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RedisClient
     */
    protected $client;

    /**
     * @var AddressBook
     */
    protected $addressBook;

    public function setUp()
    {
        $this->addressBook = new AddressBook();
        $this->client = new RedisClient();
        $this->client->clear();
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
