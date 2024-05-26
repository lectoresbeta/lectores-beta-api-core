<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Type\Collection;

use BetaReaders\Shared\Domain\Exception\CriticalException;

final class UniqueIdentifierPropertyAlreadyFilled extends CriticalException
{
    public static function default(string $key): self
    {
        return self::withMessageAndExtraItems('Property already filled', ['unique_key' => $key]);
    }
}
