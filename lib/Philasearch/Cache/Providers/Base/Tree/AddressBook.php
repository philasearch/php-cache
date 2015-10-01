<?php

/**
 * AddressBook.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache\Providers\Base\Tree;

use Philasearch\Cache\Providers\Base\BaseClient;

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
     * @param $client BaseClient
     */
    public function __construct ( $client )
    {
        $this->client = $client;
    }

    /**
     * Adds an address to the address book
     *
     * @param       $key
     * @param       $id
     * @param array $address
     */
    public function add ( $key, $id, array $address = [] )
    {
        $this->client->setHashValue($key, $id, json_encode($address));
    }

    /**
     * Gets an address from the address book
     *
     * @param $key
     * @param $id
     *
     * @return mixed
     */
    public function get ( $key, $id )
    {
        return json_decode($this->client->getHashValue($key, $id), false);
    }
}
