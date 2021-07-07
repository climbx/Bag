<?php

namespace Climbx\Bag;

use Generator;
use Traversable;
use IteratorAggregate;

class Bag implements IteratorAggregate
{
    /**
     * array of bag items
     *
     * @var array $bag
     */
    protected array $bag;

    /**
     * Bag constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->bag = $data;
    }

    /**
     * @return Generator|Traversable
     */
    public function getIterator(): Traversable | Generator
    {
        yield from $this->bag;
    }

    /**
     * Checks if an item exists in the bag.
     *
     * @param $item
     *
     * @return bool
     */
    public function has($item): bool
    {
        return array_key_exists($item, $this->bag);
    }

    /**
     * @param $item
     *
     * @return mixed|false
     */
    public function get($item)
    {
        return ($this->has($item)) ? $this->bag[$item] : false;
    }

    /**
     * @param $item
     * @param $value
     */
    public function set($item, $value): void
    {
        $this->bag[$item] = $value;
    }

    /**
     * Add an item if it's not already exists.
     *
     * @param $item
     * @param $value
     */
    public function add($item, $value): void
    {
        if (!$this->has($item)) {
            $this->set($item, $value);
        }
    }

    /**
     * @param $item
     *
     * @return bool
     */
    public function remove($item): bool
    {
        if ($this->has($item)) {
            unset($this->bag[$item]);
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->bag;
    }

    /**
     * @param array  $data
     */
    public function setAll(array $data): void
    {
        $this->bag = $data;
    }

    public function reset(): void
    {
        $this->bag = [];
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->bag);
    }
}
