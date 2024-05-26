<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Uid;

use BetaReaders\Shared\Domain\Type\StringValue;
use Ulid\Exception\InvalidUlidStringException;
use Ulid\Ulid as BaseUlid;

class Ulid extends StringValue
{
    /**
     * @throws InvalidUlidStringException
     */
    protected function guard(): void
    {
        BaseUlid::fromString($this->value)->toTimestamp();
    }
}
