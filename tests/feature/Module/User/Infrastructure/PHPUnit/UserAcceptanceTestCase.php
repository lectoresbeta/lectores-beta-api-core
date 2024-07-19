<?php

declare(strict_types=1);

namespace BetaReaders\Tests\Module\User\Infrastructure\PHPUnit;

use BetaReaders\Module\User\Domain\User;
use BetaReaders\Module\User\Test\Stub\UserStub;
use BetaReaders\Packages\PHPUnit\Symfony\AcceptanceTests;
use PHPUnit\Framework\Assert;

abstract class UserAcceptanceTestCase extends AcceptanceTests
{
    public static function constrainedUsersProvider(): array
    {
        $user = UserStub::random();

        return [
            'with email already taken' => [
                $user,
                UserStub::withSameEmailAndDistinctIdAndUsername($user),
            ],
            'with username already taken' => [
                $user,
                UserStub::withSameUsernameAndDistinctIdAndEmail($user),
            ],
        ];
    }

    protected function givenUsers(User ...$users): void
    {
        $this->persist(...$users);
    }

    protected function jsonApiFromUser(User $user): array
    {
        return [
            'data' => [
                'id' => $user->id()->value(),
                'type' => 'user',
                'attributes' => [
                    'email' => $user->email()->value(),
                    'username' => $user->username()->value(),
                    'password' => $user->password()->value(),
                ],
            ],
        ];
    }

    protected function thenUserShouldMatchWithTheStoredOnes(User $user): void
    {
        /** @var User|null $databaseUser */
        $databaseUser = $this->repositoryFor(User::class)->find($user->id());

        Assert::assertEquals($databaseUser?->id(), $user->id());
        Assert::assertEquals($databaseUser?->email(), $user->email());
        Assert::assertEquals($databaseUser?->roles(), $user->roles());
        Assert::assertEquals($databaseUser?->username(), $user->username());
        Assert::assertEquals($databaseUser?->password(), $user->password());
    }
}
