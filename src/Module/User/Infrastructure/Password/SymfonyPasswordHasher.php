<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Infrastructure\Password;

use BetaReaders\Module\User\Domain\Password;
use BetaReaders\Module\User\Domain\User;
use BetaReaders\Module\User\Domain\UserPasswordHasher;
use BetaReaders\Packages\Symfony\Security\SymfonyPasswordAuthenticatedUserFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class SymfonyPasswordHasher implements UserPasswordHasher
{
    public function __construct(
        private readonly SymfonyPasswordAuthenticatedUserFactory $factory,
        private readonly UserPasswordHasherInterface $hasher
    ) {
    }

    public function hash(User $user): Password
    {
        $symfonyUser = $this->factory->create($user->password()->value());

        $hashedPassword = $this->hasher->hashPassword($symfonyUser, $user->password()->value());

        return new Password($hashedPassword);
    }
}
