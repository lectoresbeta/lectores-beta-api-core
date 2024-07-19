<?php

declare(strict_types=1);

namespace BetaReaders\Tests\Module\User\Application;

use BetaReaders\Module\User\Application\Register\RegisterUserCommand;
use BetaReaders\Module\User\Application\Register\RegisterUserCommandHandler;
use BetaReaders\Module\User\Domain\InvalidPasswordProvided;
use BetaReaders\Module\User\Domain\InvalidUserIdentifierProvided;
use BetaReaders\Module\User\Domain\UnexpectedUserStoringError;
use BetaReaders\Module\User\Domain\UserAlreadyExist;
use BetaReaders\Module\User\Domain\UserRegisterer;
use BetaReaders\Module\User\Test\Stub\UserStub;
use BetaReaders\Module\User\Test\UserModuleTestCase;

final class RegisterUserCommandHandlerTest extends UserModuleTestCase
{
    private RegisterUserCommandHandler $handler;

    protected function setUp(): void
    {
        $registerer = new UserRegisterer($this->repository(), $this->hasher());
        $this->handler = new RegisterUserCommandHandler($registerer);
    }

    /**
     * @test
     */
    public function itShouldRegisterAnUserWithoutErrors(): void
    {
        $user = UserStub::random();

        $this->shouldGenerateHashedPassword($user, $user->password());

        $userWithRegistrationRoles = UserStub::withRegistrationRoles($user);
        $this->shouldSaveAnUserWithoutErrors($userWithRegistrationRoles);

        $command = new RegisterUserCommand(
            $user->id()->value(),
            $user->email()->value(),
            $user->username()->value(),
            $user->password()->value(),
        );

        $this->dispatch($command, $this->handler);
    }

    /**
     * @test
     */
    public function itShouldNotRegisterAnUserWhichIsAlreadyRegistered(): void
    {
        $user = UserStub::random();

        $this->shouldGenerateHashedPassword($user, $user->password());

        $userWithRegistrationRoles = UserStub::withRegistrationRoles($user);
        $this->shouldFailOnSaveGivenTheUserAlreadyExists($userWithRegistrationRoles);

        $command = new RegisterUserCommand(
            $user->id()->value(),
            $user->email()->value(),
            $user->username()->value(),
            $user->password()->value(),
        );

        $this->dispatchAndThrowException($command, $this->handler, UserAlreadyExist::class);
    }

    /**
     * @test
     */
    public function itShouldNotRegisterAnUserIfThereIsAnUnexpectedError(): void
    {
        $user = UserStub::random();

        $this->shouldGenerateHashedPassword($user, $user->password());

        $userWithRegistrationRoles = UserStub::withRegistrationRoles($user);
        $this->shouldFailOnSaveGivenAnUnexpectedStorageError($userWithRegistrationRoles);

        $command = new RegisterUserCommand(
            $user->id()->value(),
            $user->email()->value(),
            $user->username()->value(),
            $user->password()->value(),
        );

        $this->dispatchAndThrowException($command, $this->handler, UnexpectedUserStoringError::class);
    }

    /**
     * @test
     */
    public function itShouldNotRegisterAnUserGivenAnInvalidIdentifier(): void
    {
        $user = UserStub::random();

        $command = new RegisterUserCommand(
            'INVALID_USER_ID',
            $user->email()->value(),
            $user->username()->value(),
            $user->password()->value(),
        );

        $this->dispatchAndThrowException($command, $this->handler, InvalidUserIdentifierProvided::class);
    }

    /**
     * @test
     */
    public function itShouldNotRegisterAnUserIfThePasswordIsWeak(): void
    {
        $user = UserStub::random();

        $command = new RegisterUserCommand(
            $user->id()->value(),
            $user->email()->value(),
            $user->username()->value(),
            'WEAK',
        );

        $this->dispatchAndThrowException($command, $this->handler, InvalidPasswordProvided::class);
    }
}
