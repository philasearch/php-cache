<?php

namespace Philasearch\Cache\Providers\Base;

use Philasearch\Cache\Providers\Base\Objects\BaseObject;
use Philasearch\Cache\Providers\Base\Objects\BaseTree;
use Philasearch\Cache\Providers\Redis\Exceptions\CommandException;
use Philasearch\Cache\Providers\Redis\Exceptions\ConnectionException;

interface BaseClient
{
    /**
     * Expires a key in redis after a set time
     *
     * @param string $key The key in redis
     * @param integer $time The time to expire
     *
     * @return boolean
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function expire ( $key, $time );

    /**
     * Gets the value from the redis store
     *
     * @param $key
     *
     * @return string
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function get ( $key );

    /**
     * Gets a hash value from the redis store
     *
     * @param $key
     * @param $field
     *
     * @return string
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function getHashValue ( $key, $field );

    /**
     * Sets a hash value in the redis store
     *
     * @param $key
     * @param $field
     * @param $value
     *
     * @return boolean
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function setHashValue ( $key, $field, $value );

    /**
     * Gets all the hash values from the redis store
     *
     * @param $key
     *
     * @return array
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function getHashFull ( $key );

    /**
     * Deletes a value from the redis store
     *
     * @param $key
     *
     * @return boolean
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function delete ( $key );

    /**
     * Deletes a hash value from the redis store
     *
     * @param $key
     * @param $field
     *
     * @return mixed
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function deleteHashValue ( $key, $field );

    /**
     * Sets a value in the redis store
     *
     * @param string $key
     * @param string $value
     * @param integer $expire
     *
     * @return boolean
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function set ( $key, $value, $expire = 0 );

    /**
     * Clears the redis database
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function clear ();

    /**
     * Gets all keys from the redis store matching pattern
     *
     * @param $pattern
     *
     * @return mixed
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function getKeys ( $pattern );

    /**
     * Gets all of the keys from a redis hash.
     *
     * @param $hashKey
     *
     * @return mixed
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function getHashKeys ( $hashKey );

    /**
     * Returns a new object
     *
     * @param $key
     * @param $data
     * @param $expire
     *
     * @return BaseObject
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function createObject ( $key, $data, $expire );

    /**
     * Returns a new tree object
     *
     * @param string $key
     * @param integer $expire
     *
     * @return BaseTree
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function createTree ( $key, $expire = 0 );

    /**
     * Increments an integer key
     *
     * @param $key
     *
     * @return integer
     *
     * @throws CommandException
     * @throws ConnectionException
     */
    public function increment ( $key );
}
