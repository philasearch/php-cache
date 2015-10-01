<?php
use Mockery\MockInterface;
use Philasearch\Cache\Objects\CachedObject;

class CachedObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface
     */
    private $base;

    /**
     * @var CachedObject
     */
    private $object;

    public function setUp ()
    {
        parent::setUp();
        $this->base = \Mockery::mock('\Philasearch\Cache\Providers\Base\Objects\BaseObject');
        $this->object = new CachedObject('key', 0, [], $this->base);
    }

    public function testFillingInObject()
    {
        $this->base->shouldReceive('fill')->once();
        $this->base->shouldReceive('get')->once()->andReturn('bar');
        $this->object->fill(['foo' => 'bar', 'bar' => 'foo']);
        $this->assertEquals('bar', $this->object->get('foo'));
    }

    public function testSettingFieldForObject()
    {
        $this->base->shouldReceive('get')->once()->andReturn('bar');
        $this->base->shouldReceive('set')->once();
        $this->object->set('foo', 'bar');
        $this->assertEquals('bar', $this->object->get('foo'));
    }

    public function testGetAll()
    {
        $this->base->shouldReceive('getAll')->once()->andReturn(['foo' => 'bar']);
        $this->base->shouldReceive('fill')->once();
        $this->object->fill(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $this->object->getAll());
    }

    public function testDelete()
    {
        $this->base->shouldReceive('delete')->once();
        $this->object->delete('foo');
    }

    public function testDeleteAll()
    {
        $this->base->shouldReceive('deleteAll')->once();
        $this->object->deleteAll();
    }
}


