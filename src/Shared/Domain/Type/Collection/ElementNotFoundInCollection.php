<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Type\Collection;

use BetaReaders\Shared\Domain\Exception\CriticalException;

final class ElementNotFoundInCollection extends CriticalException
{
    public static function default(string $key): self
    {
        return self::withMessageAndExtraItems('Element not found in collection', ['key' => $key]);
    }
}
