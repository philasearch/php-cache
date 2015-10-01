<?php

/**
 * CachedObject.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache\Objects;

use Philasearch\Cache\Cache;
use Philasearch\Cache\ObjectType;
use Philasearch\Cache\Providers\Base\Objects\BaseObject;

/**
 * Class CachedObject
 *
 * A cached object that interacts with a set cache store to save data.
 *
 * @package Philasearch\Cache\Objects
 *
 */
class CachedObject
{
    /**
     * @var Object
     */
    private $base;

    /**
     * @var string
     */
    protected $namespace = "";

    /**
     * @var string
     */
    protected $key = "";

    /**
     * Constructs the Cached Object
     *
     * @param string $key
     * @param string $namespace
     * @param BaseObject $base
     * @param int $expire
     * @param array $data
     */
    public function __construct ( $key, $namespace='', BaseObject $base = null, $expire=0, $data=[])
    {
        $this->namespace = $namespace;
        $this->key = ( $namespace != '' ) ? "{$namespace}:{$key}" : $key;
        $this->base = ( $base != null ) ? $base : Cache::object($this->key, ObjectType::OBJECT, $data, $expire);
    }

    /**
     * Expires an object from the cache
     *
     * @param string $expire The time until expire
     */
    public function expire ( $expire )
    {
        $this->base->expire( $expire );
    }

    /**
     * Gets a field from the object
     *
     * @param $field
     *
     * @return mixed
     */
    public function get ( $field )
    {
        return $this->base->get( $field );
    }

    /**
     * Set a field for the object
     *
     * @param $field
     * @param $value
     */
    public function set ( $field, $value )
    {
        $this->base->set( $field, $value );
    }

    /**
     * Fills a object with data
     *
     * @param array $data
     */
    public function fill ( array $data )
    {
        $this->base->fill( $data );
    }

    /**
     * Gets all the fields for the object
     *
     * @return mixed
     */
    public function getAll ()
    {
        return $this->base->getAll();
    }

    /**
     * Deletes a single field from the object
     *
     * @param $key
     */
    public function delete ( $key )
    {
        $this->base->delete( $key, true );
    }

    /**
     * Deletes all the fields from the object
     */
    public function deleteAll ()
    {
        $this->base->deleteAll();
    }
}
