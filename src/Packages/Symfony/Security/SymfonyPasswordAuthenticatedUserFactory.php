<?php

declare(strict_types=1);

namespace BetaReaders\Packages\Symfony\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

final class SymfonyPasswordAuthenticatedUserFactory
{
    public function create(string $password): PasswordAuthenticatedUserInterface
    {
        return new class($password) implements PasswordAuthenticatedUserInterface {
            public function __construct(private readonly string $password)
            {
            }

            public function getPassword(): ?string
            {
                return $this->password;
            }
        };
    }
}
