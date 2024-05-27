<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

use BetaReaders\Shared\Domain\Exception\DomainException;
use BetaReaders\Shared\Domain\User\Email;
use BetaReaders\Shared\Domain\User\UserId;

final class UserAlreadyExist extends DomainException
{
    private const MESSAGE = 'User already exist';

    public static function withIdAndEmail(UserId $id, Email $email): self
    {
        return self::withMessageAndExtraItems(
            self::MESSAGE,
            [
                'user_id' => $id->value(),
                'email' => $email->value(),
            ]
        );
    }
}
