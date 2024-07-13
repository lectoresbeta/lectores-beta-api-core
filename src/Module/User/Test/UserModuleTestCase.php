<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Test;

use BetaReaders\Module\User\Domain\Password;
use BetaReaders\Module\User\Domain\UnexpectedUserStoringError;
use BetaReaders\Module\User\Domain\User;
use BetaReaders\Module\User\Domain\UserAlreadyExist;
use BetaReaders\Module\User\Domain\UserPasswordHasher;
use BetaReaders\Module\User\Domain\UserRepository;
use BetaReaders\Tests\Module\ModuleTestCase;

use function BetaReaders\Tests\similarTo;

use Mockery\MockInterface;

abstract class UserModuleTestCase extends ModuleTestCase
{
    protected UserRepository|MockInterface|null $repository = null;
    protected UserPasswordHasher|MockInterface|null $hasher = null;

    protected function repository(): UserRepository|MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(UserRepository::class);
    }

    protected function hasher(): UserPasswordHasher|MockInterface
    {
        return $this->hasher = $this->hasher ?: $this->mock(UserPasswordHasher::class);
    }

    protected function shouldGenerateHashedPassword(User $user, Password $password): void
    {
        $this->hasher()
            ->shouldReceive('hash')
            ->once()
            ->with(similarTo($user))
            ->andReturn($password);
    }

    protected function shouldSaveAnUserWithoutErrors(User $user): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with(similarTo($user));
    }

    protected function shouldFailOnSaveGivenTheUserAlreadyExists(User $user): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with(similarTo($user))
            ->andThrow(UserAlreadyExist::withIdAndEmail($user->id(), $user->email()));
    }

    protected function shouldFailOnSaveGivenAnUnexpectedStorageError(User $user): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with(similarTo($user))
            ->andThrow(UnexpectedUserStoringError::withUserAndPreviousError($user));
    }
}
