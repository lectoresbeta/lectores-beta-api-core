<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Value;

abstract class IntegerValue
{
    final public function __construct(protected int $value)
    {
        $this->guard();
    }

    protected function guard(): void
    {
    }

    public static function fromString(string $value): static
    {
        return new static((int) $value);
    }

    public function value(): int
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

    public function differentThan(self $other): bool
    {
        return $this->value() !== $other->value();
    }

    public function __toString()
    {
        return (string) $this->value();
    }
}
