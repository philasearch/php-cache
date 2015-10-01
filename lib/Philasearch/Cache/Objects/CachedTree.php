<?php

/**
 * CachedTree.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache\Objects;

use Philasearch\Cache\Cache;
use Philasearch\Cache\ObjectType;
use Philasearch\Cache\Providers\Base\Objects\BaseTree;

/**
 * Class CachedTree
 *
 * A tree that interacts with a cache store for saving data
 *
 * @package Philasearch\Cache\Objects
 */
class CachedTree
{
    /**
     * @var BaseTree
     */
    private $base;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $key;

    /**
     * Constructs the Cached Object
     *
     * @param string   $key
     * @param BaseTree $base
     */
    public function __construct ( $key, BaseTree $base = null )
    {
        $this->key = $key;
        $this->base = ($base != null) ? $base : Cache::object($this->key, ObjectType::TREE);
    }

    /**
     * Saves the tree
     *
     */
    public function save ()
    {
        $this->base->save();
    }

    /**
     * Caches a node address
     *
     * @param $id
     * @param $address
     *
     * @return mixed
     */
    public function cacheNodeAddress ( $id, $address )
    {
        $this->base->cacheNodeAddress($id, $address);
    }

    /**
     * Makes a root node
     *
     * @param       $id
     * @param array $data
     *
     * @return mixed
     */
    public function makeRootNode ( $id, $data = [] )
    {
        return $this->base->makeRootNode($id, $data);
    }

    /**
     * Returns an array of the tree's data from the
     * specified id. If the id is null, the array starts
     * at the root.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function toArray ( $id = null )
    {
        return $this->base->toArray($id);
    }

    /**
     * Returns whether or not the tree is empty
     *
     * @return boolean
     */
    public function isEmpty ()
    {
        return $this->base->isEmpty();
    }

    /**
     * Returns an array of the id of the node and its children
     *
     * @param $id
     *
     * @return mixed
     */
    public function branch ( $id )
    {
        return $this->base->branch($id);
    }
}
