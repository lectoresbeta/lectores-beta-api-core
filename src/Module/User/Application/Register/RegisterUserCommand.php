<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Application\Register;

use BetaReaders\Shared\Domain\Bus\Command\Command;

final class RegisterUserCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $username,
        public readonly string $password
    ) {
    }
}
