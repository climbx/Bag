<?php

namespace Climbx\Bag;

use Generator;
use Traversable;

class Bag implements BagInterface
{
    /**
     * array of bag items
     *
     * @var array $bag
     */
    protected array $bag;

    /**
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
     * @return int|string|object|array|bool|null
     */
    public function get($item): int | string | object | array | bool | null
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
