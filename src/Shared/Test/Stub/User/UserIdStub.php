<?php
declare(strict_types=1);

namespace BetaReaders\Shared\Test\Stub\User;

use BetaReaders\Shared\Domain\User\UserId;
use BetaReaders\Shared\Test\Stub\UlidStub;

final class UserIdStub
{
    public static function random(): UserId
    {
        return new UserId((string) UlidStub::random());
    }
}