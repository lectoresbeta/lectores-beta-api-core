<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

use BetaReaders\Shared\Domain\User\Email;
use BetaReaders\Shared\Domain\User\UserId;

final class UserRegisterer
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserPasswordHasher $passwordHasher,
    ) {
    }

    /**
     * @throws UserAlreadyExist
     */
    public function register(string $id, string $username, string $email, string $password): void
    {
        [$id, $username, $email, $password] = [
            new UserId($id),
            new Username($username),
            new Email($email),
            Password::plain($password),
        ];

        $user = User::registerWithPlainPassword($this->passwordHasher, $id, $username, $email, $password);

        $this->repository->save($user);
    }
}
