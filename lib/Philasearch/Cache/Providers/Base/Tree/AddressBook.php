<?php

/**
 * AddressBook.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache\Providers\Base\Tree;

use Philasearch\Cache\Providers\Base\BaseClient;
use Philasearch\Cache\Providers\Redis\Exceptions\CommandException;
use Philasearch\Cache\Providers\Redis\Exceptions\ConnectionException;

/**
 * Class AddressBook
 *
 * Stores the address of a trees node for quick access.
 *
 * @package Philasearch\Cache\Providers\Redis\Objects\Tree
 *
 */
class AddressBook
{
    /**
     * @var BaseClient
     */
    private $client;

    /**
     * @var string
     */
    private $key;

    /**
     * @var integer
     */
    private $expire = 0;

    /**
     * @param BaseClient $client
     * @param string $key
     * @param int $expire
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function __construct ( $client, $key, $expire = 0 )
    {
        $this->client = $client;
        $this->key = $key;
        $this->expire = $expire;
    }

    /**
     * Adds an address to the address book
     *
     * @param string $id
     * @param array $address
     *
     * @return boolean
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function add ( $id, array $address = [] )
    {
        $result = $this->client->setHashValue($this->key, $id, json_encode($address));

        if ( $this->expire != 0 )
        {
            $this->client->expire($this->key, $this->expire);
        }

        return $result;
    }

    /**
     * Gets an address from the address book
     *
     * @param $id
     *
     * @return array
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function get ( $id )
    {
        return json_decode($this->client->getHashValue($this->key, $id), false);
    }
}
