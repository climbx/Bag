<?php

namespace Climbx\Bag;

use Climbx\Bag\Exception\MissingItemException;
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
     * @inheritDoc
     */
    public function has($item): bool
    {
        return array_key_exists($item, $this->bag);
    }

    /**
     * @inheritDoc
     */
    public function get($item): int | string | object | array | bool | null
    {
        return ($this->has($item)) ? $this->bag[$item] : false;
    }

    /**
     * @inheritDoc
     */
    public function require($item, string $errorMessage = null): int | string | object | array | bool | null
    {
        if (!$this->has($item)) {
            $message = (null === $errorMessage) ?
                sprintf('The parameter "%s" is missing', $item) : str_replace("{item}", $item, $errorMessage);

            throw new MissingItemException($message);
        }

        return $this->bag[$item];
    }

    /**
     * @inheritDoc
     */
    public function set($item, $value): void
    {
        $this->bag[$item] = $value;
    }

    /**
     * @inheritDoc
     */
    public function add($item, $value): void
    {
        if (!$this->has($item)) {
            $this->set($item, $value);
        }
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->bag;
    }

    /**
     * @inheritDoc
     */
    public function setAll(array $data): void
    {
        $this->bag = $data;
    }

    /**
     * @inheritDoc
     */
    public function reset(): void
    {
        $this->bag = [];
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return empty($this->bag);
    }
}
