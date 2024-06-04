<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

use BetaReaders\Shared\Domain\Exception\DomainException;

final class InvalidUserIdentifierProvided extends DomainException
{
    private const MESSAGE = 'An invalid user identifier has been provided';

    public static function withId(string $userId): self
    {
        return self::withMessageAndExtraItems(
            self::MESSAGE,
            [
                'invalid_user_id' => $userId,
            ]
        );
    }
}
