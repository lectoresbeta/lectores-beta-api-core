<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Application\Register;

use BetaReaders\Module\User\Domain\UserRegisterer;

final class RegisterUserCommandHandler
{
    public function __construct(private readonly UserRegisterer $registerer)
    {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $this->registerer->register(
            $command->id,
            $command->username,
            $command->email,
            $command->password
        );
    }
}
