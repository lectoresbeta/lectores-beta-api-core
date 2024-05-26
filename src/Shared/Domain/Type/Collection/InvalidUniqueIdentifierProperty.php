<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Type\Collection;

use BetaReaders\Shared\Domain\Exception\CriticalException;

final class InvalidUniqueIdentifierProperty extends CriticalException
{
    public static function default(): self
    {
        return new self('Unique identifier for unique collection not found', 0);
    }
}
