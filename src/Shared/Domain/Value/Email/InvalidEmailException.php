<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Value\Email;

use BetaReaders\Shared\Domain\Exception\DomainException;

class InvalidEmailException extends DomainException
{
    private const MESSAGE = 'Invalid email provided.';

    public static function withEmail(string $email): InvalidEmailException
    {
        return static::withMessageAndExtraItems(self::MESSAGE, ['email' => $email]);
    }
}
