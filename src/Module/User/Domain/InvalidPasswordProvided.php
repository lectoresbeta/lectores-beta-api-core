<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

use BetaReaders\Shared\Domain\Exception\DomainException;

final class InvalidPasswordProvided extends DomainException
{
    private const MESSAGE = 'An invalid password has been provided';

    public static function passwordTooShort(): self
    {
        return new self(self::MESSAGE, 0, null, ['reason' => 'Password too short']);
    }
}
