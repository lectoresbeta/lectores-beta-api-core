<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\User;

use BetaReaders\Module\User\Domain\InvalidUserIdentifierProvided;
use BetaReaders\Shared\Domain\Uid\Ulid;
use Ulid\Exception\InvalidUlidStringException;

final class UserId extends Ulid
{
    /**
     * @throws InvalidUserIdentifierProvided
     */
    protected function guard(): void
    {
        try {
            parent::guard();
        } catch (InvalidUlidStringException) {
            throw InvalidUserIdentifierProvided::withId($this->value);
        }
    }
}
