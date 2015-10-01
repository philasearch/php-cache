<?php

use Mockery\MockInterface;
use Philasearch\Cache\Objects\CachedTree;

class CachedTreeTest extends TestCase
{
    /**
     * @var MockInterface
     */
    private $base;

    /**
     * @var CachedTree
     */
    private $tree;

    public function setUp ()
    {
        $this->base = \Mockery::mock('\Philasearch\Cache\Providers\Base\Objects\BaseTree');
        $this->tree = new CachedTree('key', $this->base );
    }

    public function testSave()
    {
        $this->base->shouldReceive('save')->once();

        $this->tree->save();
    }

    public function testCacheNodeAddress()
    {
        $this->base->shouldReceive('cacheNodeAddress')->once();

        $this->tree->cacheNodeAddress('key', [0]);
    }

    public function testMakeRootNode()
    {
        $this->base->shouldReceive('makeRootNode')->once();

        $this->tree->makeRootNode('root');
    }

    public function testGetData()
    {
        $this->base->shouldReceive('getData')->once();

        $this->tree->getData();
    }

    public function testBranch()
    {
        $this->base->shouldReceive('branch')->once();

        $this->tree->branch(1);
    }
}

