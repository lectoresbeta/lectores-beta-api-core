<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Test\Stub;

use BetaReaders\Module\User\Domain\Password;
use BetaReaders\Shared\Test\Stub\StubCreator;

final class PasswordStub
{
    public static function random(): Password
    {
        return new Password(StubCreator::random()->password(minLength: 10));
    }
}
