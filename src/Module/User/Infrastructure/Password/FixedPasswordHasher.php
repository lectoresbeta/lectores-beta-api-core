<?php
declare(strict_types=1);

namespace BetaReaders\Module\User\Infrastructure\Password;

use BetaReaders\Module\User\Domain\Password;
use BetaReaders\Module\User\Domain\User;
use BetaReaders\Module\User\Domain\UserPasswordHasher;

final class FixedPasswordHasher implements UserPasswordHasher
{
    public function hash(User $user): Password
    {
        return $user->password();
    }
}