<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Test\Stub;

use BetaReaders\Module\User\Domain\User;
use BetaReaders\Shared\Domain\User\UserRoles;
use BetaReaders\Shared\Test\Stub\User\UserIdStub;

final class UserStub
{
    public static function random(): User
    {
        return new User(
            UserIdStub::random(),
            EmailStub::random(),
            UsernameStub::random(),
            UserRoles::empty(),
            PasswordStub::random(),
        );
    }

    public static function fromUserWithRegistrationRoles(User $user): User
    {
        return new User(
            $user->id(),
            $user->email(),
            $user->username(),
            UserRoles::registrationRoles(),
            $user->password(),
        );
    }
}
