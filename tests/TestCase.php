<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Philasearch\Cache\Providers\Base\Tree\AddressBook;
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

    public function setUp ()
    {
        $this->client = new RedisClient();
        $this->addressBook = new AddressBook($this->client);

        $this->client->clear();
    }

    public function tearDown ()
    {
        \Mockery::close();
    }
}
