<?php

/**
 * Node.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache\Providers\Redis\Objects\Tree;

use Philasearch\Cache\Providers\Redis\Objects\Tree as Tree;

/**
 * Class Node
 *
 * Node from a tree for storing hierarchical data.
 *
 * @package Philasearch\Cache\Providers\Redis\Objects\Tree
 *
 */
class Node
{
    private $id         = null;
    private $data       = null;
    private $tree       = null;
    private $address    = [];
    private $children   = [];

    /**
     * Constructs the node
     *
     * @param $id
     * @param Tree $tree
     * @param array $data
     *
     */
    public function __construct($id, Tree $tree=null, $data=[])
    {
        $this->data         = $data;
        $this->data['id']   = $id;
        $this->address      = [0];
        $this->id           = $id;
        $this->tree         = $tree;

        $this->resume();
    }

    /**
     * Gets the node data
     *
     * @return array|null
     *
     */
    public function getData()
    {
        $data = $this->data;

        foreach ($this->children as $child)
        {
            $data['children'][] = $child->getData();
        }

        return $data;
    }

    /**
     * Sets the node value for a field
     *
     * @param $field
     * @param $value
     *
     */
    public function __set($field, $value)
    {
        $this->data[$field] = $value;
    }

    /**
     * Get the node value from a field
     *
     * @param $field
     *
     * @return mixed
     *
     */
    public function __get($field)
    {
        return $this->data[$field];
    }

    /**
     * Adds a child to the node
     *
     */
    public function addChild($id, $data=[])
    {
        $child      = new Node($id, $this->tree, $data);
        $address    = $this->address;
        $address[]  = count($this->children);
        $this->children[]    = $child;

        $child->setAddress($address);

        return $child;
    }

    /**
     * Sets a node address
     *
     * @param $address
     *
     */
    public function setAddress($address)
    {
        $this->address = $address;

        if ( $this->tree != null)
        {
            $this->tree->cacheNodeAddress($this->id, $address);
        }
    }

    /**
     * Gets a node's address
     *
     * @return array
     *
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Gets the children of the node
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Resumes a node
     *
     */
    private function resume()
    {
        if (array_key_exists('children', $this->data))
        {
            $children = (array_key_exists('children', $this->data)) ? $this->data['children'] : [];
            $this->data['children'] = [];

            foreach ($children as $child_cache)
            {
                $this->addChild($child_cache['id'],$child_cache);
            }
        }
    }

}