<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

use BetaReaders\Shared\Domain\User\Email;
use BetaReaders\Shared\Domain\User\UserId;
use BetaReaders\Shared\Domain\User\UserRoles;

class User
{
    public function __construct(
        private readonly UserId $id,
        private readonly Email $email,
        private readonly Username $username,
        private readonly Password $password,
        private readonly UserRoles $roles,
    ) {
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
