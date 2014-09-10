<?php

/**
 * CachedTree.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache\Objects;

use Philasearch\Cache\Cache;
use Philasearch\Cache\Providers\Base\Objects\BaseTree as BaseTree;
use Philasearch\Cache\ObjectType;

/**
 * Class CachedTree
 *
 * A tree that interacts with a cache store for saving data
 *
 * @package Philasearch\Cache\Objects
 *
 */

class CachedTree
{
    private     $base       = null;
    protected   $namespace  = "";
    protected   $key        = "";

    /**
     * Constructs the Cached Object
     *
     * @param       $key
     * @param array $opts
     */
    public function __construct ($key, array $opts=[])
    {
        $this->namespace    = (array_key_exists('namespace', $opts))    ? $opts['namespace']            : $this->namespace;
        $this->key          = ($this->namespace != "")                  ? $this->namespace . ':' . $key : $key;
        $this->base         = (array_key_exists('base', $opts))         ? $opts['base']                 : Cache::object($this->key, ObjectType::TREE);
    }

    /**
     * Saves the tree
     *
     */
    public function save()
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
     *
     */
    public function cacheNodeAddress($id, $address)
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
    public function makeRootNode($id, $data=[])
    {
        return $this->base->makeRootNode($id, $data);
    }

    /**
     * Gets data from the tree based on tree id
     *
     * @param null $id
     *
     * @return mixed
     *
     */
    public function getData($id=null)
    {
        return $this->base->getData($id);
    }

    /**
     * Returns an array of the id of the node and its children
     *
     * @param $id
     *
     * @return mixed
     *
     */
    public function branch($id)
    {
        return $this->base->branch($id);
    }
} 