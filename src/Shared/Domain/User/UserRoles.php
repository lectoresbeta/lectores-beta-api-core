<?php
declare(strict_types=1);

namespace BetaReaders\Shared\Domain\User;

use BetaReaders\Shared\Domain\Type\Collection\Collection;
use function Lambdish\Phunctional\map;

final class UserRoles extends Collection
{
    public static function type(): string
    {
        return UserRole::class;
    }

    public static function fromPlain(array $roles): self
    {
        return new self(
            map(
                function (string $role) {
                    return UserRole::from($role);
                },
                $roles
            )
        );
    }
}