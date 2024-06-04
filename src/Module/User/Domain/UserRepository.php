<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

interface UserRepository
{
    /**
     * @throws UserAlreadyExist
     * @throws UnexpectedUserStoringError
     */
    public function save(User $user): void;
}
