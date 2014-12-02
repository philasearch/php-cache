<?php

/**
 * Object.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache\Providers\Redis\Objects;

use Philasearch\Cache\Providers\Redis\Client as Client;
use Philasearch\Cache\Providers\Base;

/**
 * Class Object
 *
 * An object that interacts whose data is stored in redis
 *
 * @package Philasearch\Cache\Providers\Redis\Objects
 *
 */
class Object implements Base\Objects\BaseObject
{
    private $key    = '';
    private $data   = [];

    /**
     * Constructs a redis object
     *
     * @param $key
     * @param array $data
     */
    public function __construct ( $key, array $data=[], $expire=0 )
    {
        $this->key  = $key;
        $this->data = $this->getAll();

        if ( $expire != 0 )
            $this->expire( $expire );

        $this->fill( $data );
    }


    /**
     * Expires the object after a set time
     *
     * @param interger  $time   The time to expire
     */
    public function expire ( $time )
    {
        Client::expire( $this->key, $time );
    }

    /**
     * Sets a value in the redis store for the object
     *
     * @param $field
     * @param $value
     *
     * @return mixed|void
     */
    public function __set ( $field, $value )
    {
        $this->set( $field, $value );
    }

    /**
     * Sets a field for the object
     *
     * @param $field
     * @param $value
     *
     * @return mixed|void
     */
    public function set ( $field, $value )
    {
        Client::hset( $this->key, $field, $value );

        $this->data = $this->getAll();
    }

    /**
     * Fills in fields for the object
     *
     * @param array $data
     */
    public function fill ( array $data )
    {
        foreach ( $data as $key => $value )
            $this->set( $key, $value );

        $this->data = $this->getAll();
    }
    /**
     * Gets the data from the redis store for the object
     *
     * @param $field
     *
     * @return mixed
     */
    public function __get ( $field )
    {
        return $this->get( $field );
    }

    /**
     * Gets a variable from the redis cache for the object
     *
     * @param $field
     *
     * @return mixed
     */
    public function get ( $field )
    {
        return Client::hget( $this->key, $field );
    }

    /**
     * Gets all the data from the redis store
     *
     * @return mixed
     */
    public function getAll ()
    {
        return Client::hgetall( $this->key );
    }

    /**
     * Deletes all the data from the redis store
     */
    public function delete ( $key, $refreshData=true )
    {
        Client::hdel( $this->key, $key );

        if ( $refreshData )
            $this->data = $this->getAll();
    }

    /**
     * Deletes all the data from the redis store for the object
     */
    public function deleteAll ()
    {
        $data = Client::hgetall( $this->key );

        foreach ( $data as $key => $value )
            $this->delete( $key, false );

        $this->data = [];
    }
}
