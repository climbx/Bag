<?php

namespace Climbx\Bag;

use Climbx\Bag\Exception\NotFoundExceptionInterface;

interface BagInterface extends \IteratorAggregate
{
    /**
     * Checks if bag contains the item
     *
     * @param $item
     *
     * @return bool
     */
    public function has($item): bool;

    /**
     * Returns bag item's value.
     *
     * @param $item
     *
     * @return int|string|object|array|bool|null
     *
     * @throws NotFoundExceptionInterface
     */
    public function get($item): int | string | object | array | bool | null;

    /**
     * Sets item value.
     *
     * If it don't exists, it is added, if it already exists, it is overridden.
     *
     * @param $item
     * @param $value
     */
    public function set($item, $value): void;

    /**
     * Removes an item from the bag if exists.
     *
     * If it exists, the function returns true, else it returns false.
     *
     * @param $item
     *
     * @return bool
     */
    public function unset($item): bool;

    /**
     * Returns all bag data.
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Sets all bag data.
     *
     * If bag is not empty, all data that already exists is deleted.
     *
     * @param array $data
     */
    public function setAll(array $data): void;

    /**
     * Removes all bag data.
     */
    public function reset(): void;

    /**
     * Checks if bag is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool;
}
