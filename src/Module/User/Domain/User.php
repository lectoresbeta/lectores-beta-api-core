<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

use BetaReaders\Shared\Domain\Aggregate\AggregateRoot;
use BetaReaders\Shared\Domain\User\Email;
use BetaReaders\Shared\Domain\User\UserId;
use BetaReaders\Shared\Domain\User\UserRoles;

class User extends AggregateRoot
{
    public function __construct(
        private readonly UserId $id,
        private readonly Email $email,
        private readonly Username $username,
        private readonly UserRoles $roles,
        private Password $password,
    ) {
    }

    public static function registerWithPlainPassword(
        UserPasswordHasher $hasher,
        UserId $id,
        Username $username,
        Email $email,
        Password $plainPassword
    ): User {
        $userWithPlainPassword = new self($id, $email, $username, UserRoles::empty(), $plainPassword);

        return new self(
            $id,
            $email,
            $username,
            UserRoles::registrationRoles(),
            $hasher->hash($userWithPlainPassword)
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function password(): Password
    {
        return $this->password;
    }

    public function roles(): UserRoles
    {
        return $this->roles;
    }
}
