<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Type;

abstract class StringValue
{
    final public function __construct(protected string $value)
    {
        $this->guard();
    }

    protected function guard(): void
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equalsTo(self $other): bool
    {
        return $other->value() === $this->value;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function __toString()
    {
        return $this->value();
    }
}
