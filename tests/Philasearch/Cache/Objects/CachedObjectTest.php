<?php

use Philasearch\Cache\Objects\CachedObject;

class CachedObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CachedObject
     */
    private $cachedObject;

    /**
     * @var string
     */
    private $key;

    public function setUp ()
    {
        parent::setUp();

        $this->key = 'key';
        $this->cachedObject = new CachedObject($this->key);
        $this->cachedObject->deleteAll();
    }

    public function testFillingInObject ()
    {
        $this->cachedObject->fill(['foo' => 'bar', 'bar' => 'foo']);

        $this->assertEquals('bar', $this->cachedObject->foo);
    }

    public function testSettingFieldForObject()
    {
        $this->cachedObject->foo = 'bar';

        $this->assertEquals('bar', $this->cachedObject->foo);
    }

    public function testGetAll()
    {
        $this->cachedObject->fill(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $this->cachedObject->getAll());
    }

    public function testDelete ()
    {
        $this->cachedObject->fill(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $this->cachedObject->getAll());
        $this->cachedObject->delete('foo');

        $this->cachedObject = new CachedObject( $this->key );
        $this->assertEquals([], $this->cachedObject->getAll());
    }

    public function testDeleteAll ()
    {
        $this->cachedObject->fill(['foo' => 'bar', 'bar' => 'foo']);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $this->cachedObject->getAll());
        $this->cachedObject->deleteAll();

        $this->cachedObject = new CachedObject( $this->key );
        $this->assertEquals([], $this->cachedObject->getAll());
    }
}

