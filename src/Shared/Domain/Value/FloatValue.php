<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Value;

abstract class FloatValue
{
    final public function __construct(protected float $value)
    {
    }

    public function value(): float
    {
        return $this->value;
    }

    public function equalsTo(self $other): bool
    {
        return $other->value() === $this->value;
    }

    public function greaterThan(self $other): bool
    {
        return $this->value() > $other->value();
    }

    public function lessThan(self $other): bool
    {
        return $this->value() < $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public function toInteger(): int
    {
        return (int) ($this->value * 100);
    }
}
