<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

use BetaReaders\Shared\Domain\User\Email;

interface UserRepository
{
    /**
     * @throws UserAlreadyExist
     */
    public function save(User $user): void;

    public function searchByEmail(Email $email): ?User;
}
