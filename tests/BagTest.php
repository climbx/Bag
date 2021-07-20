<?php

namespace Climbx\Bag\Tests;

use Climbx\Bag\Bag;
use Climbx\Bag\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Climbx\Bag\Bag
 */
class BagTest extends TestCase
{
    public function testIsEmpty()
    {
        $bag = new Bag();

        $this->assertTrue($bag->isEmpty());
    }

    public function testGet()
    {
        $bag = new Bag(['foo' => 'bar']);
        $this->assertEquals('bar', $bag->get('foo'));
    }

    public function testGetMissingItemWithDefaultMessage()
    {
        $bag = new Bag();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('The parameter "foo" is missing');

        $bag->get('foo');
    }

    public function testGetMissingItemWithCustomMessage()
    {
        $bag = new Bag();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('The parameter "foo" is missing in .env');

        $bag->get('foo', 'The parameter "foo" is missing in .env');
    }

    public function testGetWithCustomMessageAndMagicVar()
    {
        $bag = new Bag();
        $this->expectExceptionMessage('The parameter "foo" is missing in .env');

        $bag->get('foo', 'The parameter "{item}" is missing in .env');
    }

    public function testHas()
    {
        $bag = new Bag();
        $this->assertFalse($bag->has('foo'));

        $bag = new Bag(['foo' => 'bar']);
        $this->assertTrue($bag->has('foo'));
    }

    public function testSet()
    {
        $bag = new Bag();
        $bag->set('FOO', 'BAR');

        $this->assertTrue($bag->has('FOO'));
        $this->assertEquals('BAR', $bag->get('FOO'));

        // set function overrides the value if it already exists.
        $bag->set('FOO', 'BAZ');
        $this->assertEquals('BAZ', $bag->get('FOO'));
    }

    public function testUnset()
    {
        $bag = new Bag(['FOO' => 'BAR', 'BAR' => 'BAZ']);
        $result = $bag->unset('BAR');

        $this->assertFalse($bag->has('BAR'));
        $this->assertTrue($bag->has('FOO'));

        $this->assertTrue($result);
        $this->assertFalse($bag->unset('MISSING'));
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

        $this->assertTrue($bag->has('FOO'));
        $this->assertTrue($bag->has('BAR'));
        $this->assertEquals($data, $bag->getAll());
    }

    public function testReset()
    {
        $bag = new Bag(['FOO' => 'BAR', 'BAR' => 'BAZ']);
        $bag->reset();

        $this->assertTrue($bag->isEmpty());
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
