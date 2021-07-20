<?php

namespace Climbx\Bag;

use Climbx\Bag\Exception\NotFoundException;
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

    public function has($item): bool
    {
        return array_key_exists($item, $this->bag);
    }

    public function get($item, string $errorMessage = null): int | string | object | array | bool | null
    {
        if (!$this->has($item)) {
            $message = (null === $errorMessage) ?
                sprintf('The parameter "%s" is missing', $item) : str_replace("{item}", $item, $errorMessage);

            throw new NotFoundException($message);
        }

        return $this->bag[$item];
    }

    public function set($item, $value): void
    {
        $this->bag[$item] = $value;
    }

    public function unset($item): bool
    {
        if ($this->has($item)) {
            unset($this->bag[$item]);
            return true;
        }

        return false;
    }

    public function getAll(): array
    {
        return $this->bag;
    }

    public function setAll(array $data): void
    {
        $this->bag = $data;
    }

    public function reset(): void
    {
        $this->bag = [];
    }

    public function isEmpty(): bool
    {
        return empty($this->bag);
    }
}
