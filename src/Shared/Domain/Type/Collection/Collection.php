<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Type\Collection;

use BetaReaders\Shared\Domain\Type\Assert;

use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\first;
use function Lambdish\Phunctional\last;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\search;

abstract class Collection implements \Countable, \IteratorAggregate
{
    public function __construct(protected array $items)
    {
        Assert::arrayOf(static::type(), $this->items);
    }

    public static function empty(): self
    {
        $class = static::class;

        return new $class([]);
    }

    abstract public static function type(): string;

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items());
    }

    public function count(): int
    {
        return count($this->items());
    }

    public function items(): array
    {
        return $this->items;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function each(callable $fn): void
    {
        each($fn, $this->items());
    }

    public function filter(callable $fn): array
    {
        return filter($fn, $this->items());
    }

    public function map(callable $fn): array
    {
        return map($fn, $this->items());
    }

    protected function search(callable $fn): mixed
    {
        return search($fn, $this->items());
    }

    public function reduce(callable $fn, mixed $initial = null): mixed
    {
        return reduce($fn, $this->items(), $initial) ?? [];
    }

    public function first(): mixed
    {
        return first($this->items());
    }

    public function last(): mixed
    {
        return last($this->items());
    }
}
