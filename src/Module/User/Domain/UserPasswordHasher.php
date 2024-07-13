<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

interface UserPasswordHasher
{
    public function hash(User $user): Password;
}
