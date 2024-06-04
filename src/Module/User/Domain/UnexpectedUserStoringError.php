<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

use BetaReaders\Shared\Domain\Exception\CriticalException;

final class UnexpectedUserStoringError extends CriticalException
{
    private const MESSAGE = 'An unexpected error occurred storing an user';

    public static function withUserAndPreviousError(User $user, ?\Throwable $previous = null): self
    {
        return new self(self::MESSAGE, 0, $previous, [
            'user_email' => $user->email()->value(),
        ]);
    }
}
