<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Value;

abstract class BoolValue
{
    public function __construct(protected bool $value)
    {
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function equalsTo(self $other): bool
    {
        return $other->value() === $this->value;
    }

    public function isTrue(): bool
    {
        return true === $this->value;
    }

    public function isFalse(): bool
    {
        return false === $this->value;
    }

    public function __toString()
    {
        return $this->value() ? 'true' : 'false';
    }
}
