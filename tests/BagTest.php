<?php

namespace Climbx\Bag\Tests;

use Climbx\Bag\Bag;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Climbx\Bag\Bag
 */
class BagTest extends TestCase
{
    public function testIsEmpty()
    {
        $bag = new Bag();

        $this->assertEquals(true, $bag->isEmpty());
    }

    public function testGet()
    {
        $bag = new Bag();
        $this->assertEquals(false, $bag->get('foo'));

        $bag = new Bag(['foo' => 'bar']);
        $this->assertEquals('bar', $bag->get('foo'));
    }

    public function testHas()
    {
        $bag = new Bag();
        $this->assertEquals(false, $bag->has('foo'));

        $bag = new Bag(['foo' => 'bar']);
        $this->assertEquals(true, $bag->has('foo'));
    }

    public function testSet()
    {
        $bag = new Bag();
        $bag->set('FOO', 'BAR');

        $this->assertEquals(true, $bag->has('FOO'));
        $this->assertEquals('BAR', $bag->get('FOO'));

        // set function overrides the value if it already exists.
        $bag->set('FOO', 'BAZ');
        $this->assertEquals('BAZ', $bag->get('FOO'));
    }

    public function testAdd()
    {
        $bag = new Bag();
        $bag->add('FOO', 'BAR');

        $this->assertEquals(true, $bag->has('FOO'));
        $this->assertEquals('BAR', $bag->get('FOO'));

        // add function don't overrides the value if it already exists.
        $bag->add('FOO', 'BAZ');
        $this->assertEquals('BAR', $bag->get('FOO'));
    }

    public function testRemove()
    {
        $bag = new Bag(['FOO' => 'BAR', 'BAR' => 'BAZ']);
        $result = $bag->remove('BAR');

        $this->assertEquals(false, $bag->has('BAR'));
        $this->assertEquals(true, $bag->has('FOO'));

        $this->assertEquals(true, $result);
        $this->assertEquals(false, $bag->remove('MISSING'));
    }

    public function testGetAll()
    {
        $data = ['FOO' => 'BAR', 'BAR' => 'BAZ'];
        $bag = new Bag($data);

        $this->assertEquals($data, $bag->getAll());
    }

    public function testSetAll()
    {
        $data = ['FOO' => 'BAR', 'BAR' => 'BAZ'];
        $bag = new Bag();

        $bag->setAll($data);

        $this->assertEquals(true, $bag->has('FOO'));
        $this->assertEquals(true, $bag->has('BAR'));
        $this->assertEquals($data, $bag->getAll());
    }

    public function testReset()
    {
        $bag = new Bag(['FOO' => 'BAR', 'BAR' => 'BAZ']);
        $bag->reset();

        $this->assertEquals(true, $bag->isEmpty());
    }

    public function testIterator()
    {
        $bag = new Bag(['FOO' => 'BAR', 'BAR' => 'BAZ']);

        $data = [];
        foreach ($bag as $key => $value) {
            $data[$key] = $value;
        }

        $this->assertEquals($data, $bag->getAll());
    }
}
