<?php
declare(strict_types=1);

namespace BetaReaders\Module\User\Test\Stub;

use BetaReaders\Module\User\Domain\Username;
use BetaReaders\Shared\Test\Stub\StubCreator;

final class UsernameStub
{
    public static function random(): Username
    {
        return new Username(StubCreator::random()->userName());
    }
}