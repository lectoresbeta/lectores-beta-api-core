<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Type;

abstract class DateTimeValue
{
    final public function __construct(protected \DateTimeImmutable $value)
    {
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }
}
