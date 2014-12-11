<?php

use Philasearch\Cache\Providers\Redis\Objects\Tree as Tree;
use Philasearch\Cache\Providers\Redis\Client as Client;

class TreeTest extends TestCase
{
    public function testRootNode()
    {
        $tree = new Tree('key');
        $root = $tree->makeRootNode("id");

        $this->assertNotNull($root);
        $this->assertEquals([0], $root->getAddress());
    }

    public function testCacheOfRootNodeAddress()
    {
        $tree = new Tree('key');
        $root = $tree->makeRootNode("id");

        $this->assertNotNull($root);
        $this->assertEquals([0], $root->getAddress());;
        $this->assertEquals([0], Tree\AddressBook::get('key:addresses', "id"));
    }

    public function testGetDataWithHierarchyDepth1()
    {
        $tree = new Tree('key');
        $tree->makeRootNode("id", ['foo' => 'bar']);
        $this->assertEquals(["id" => "id", "foo" => "bar"], $tree->getData());
    }

    public function testGetDataWithHierarchyDepth2()
    {
        $tree = new Tree('key');
        $root = $tree->makeRootNode('0', ['foo' => 'bar']);
        $root->addChild('1', ["foo" => "bar2"]);

        $expect = [
            "id"        => '0',
            "foo"       => "bar",
            "children"  => [
                [
                    "id"    => '1',
                    "foo"   => "bar2"
                ]
            ]
        ];

        $this->assertEquals($expect, $tree->getData());
    }

    public function testGetDataWithHierarchyDepth3()
    {
        $tree   = new Tree('key');
        $root   = $tree->makeRootNode('0', ['foo' => 'bar']);
        $child  = $root->addChild('1', ["foo" => "bar2"]);

        $child->addChild('2', ['foo' => 'bar3']);

        $expect = [
            'id'        => '0',
            'foo'       => 'bar',
            'children'  => [
                [
                    'id'        => '1',
                    'foo'       => 'bar2',
                    'children'  => [
                        [
                            'id'    => '2',
                            'foo'   => 'bar3'
                        ]
                    ]
                ]
            ]
        ];

        $this->assertEquals($expect, $tree->getData());
    }

    public function testGetBranch()
    {
        $tree   = new Tree('key');
        $root   = $tree->makeRootNode('0', ['foo' => 'bar']);
        $child  = $root->addChild('1', ["foo" => "bar2"]);

        $child->addChild('2', ['foo' => 'bar3']);

        $expect = [
            'id'        => '1',
            'foo'       => 'bar2',
            'children'  => [
                [
                    'id'    => '2',
                    'foo'   => 'bar3'
                ]
            ]
        ];

        $this->assertEquals($expect, $tree->getData(1));
    }

    public function testTreeCaching()
    {
        $tree   = new Tree('tree');
        $root   = $tree->makeRootNode('0', ['foo' => 'bar']);
        $child  = $root->addChild('1', ["foo" => "bar2"]);

        $child->addChild('2', ['foo' => 'bar3']);
        $tree->save();

        $array = [
            [
                'foo'       => 'bar',
                'id'        => '0',
                'children'  => [
                    [
                        'foo'       => 'bar2',
                        'id'        => '1',
                        'children'  => [
                            [
                                'foo'   => 'bar3',
                                'id'    => '2',
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $expect = json_encode($array);

        $this->assertEquals($expect, Client::get('tree'));
    }

    public function testTreeResume()
    {
        $tree   = new Tree('tree');
        $root   = $tree->makeRootNode('1', ['foo' => 'bar']);
        $child  = $root->addChild('2', ["foo" => "bar2"]);
        $child->addChild('3', ['foo' => 'bar3']);
        $tree->save();

        $expectData = $tree->getData();

        $this->assertEquals(['1','2','3'], $tree->branch(1));
        $this->assertEquals(['2','3'], $tree->branch(2));
        $this->assertEquals(['3'], $tree->branch(3));

        $tree = new Tree('tree');

        $root = $tree->getRoot();
        $child = $root->getChildren()[0];
        $grandchild = $child->getChildren()[0];

        $this->assertEquals([0], $root->getAddress());
        $this->assertEquals([0,0], $child->getAddress());
        $this->assertEquals([0,0,0], $grandchild->getAddress());

        $this->assertEquals(['1','2','3'], $tree->branch(1));
        $this->assertEquals(['2','3'], $tree->branch(2));
        $this->assertEquals(['3'], $tree->branch(3));

        $this->assertEquals($expectData, $tree->getData());
    }

    public function testTreeBranch()
    {
        $tree   = new Tree('tree');
        $root   = $tree->makeRootNode('0', ['foo' => 'bar']);
        $root->addChild('1', ["foo" => "bar2"]);
        $tree->save();

        $this->assertEquals(['0','1'], $tree->branch('0'));
    }

}
