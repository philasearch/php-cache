<?php
namespace RubyRainbows\Cache\Providers\Redis\Objects\Tree;

use RubyRainbows\Cache\Providers\Redis\Client as Client;

class AddressBook
{
    /**
     * Adds an address to the address book
     *
     * @param $key
     * @param $id
     * @param array $address
     */
    public static function add($key, $id, array $address=[])
    {
        Client::hset($key,$id, json_encode($address));
    }

    /**
     * Gets an address from the address book
     *
     * @param $key
     * @param $id
     *
     * @return mixed
     */
    public static function get($key, $id)
    {
        return json_decode(Client::hget($key, $id), false);
    }
}