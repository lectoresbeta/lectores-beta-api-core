<?php

declare(strict_types=1);

namespace BetaReaders\Tests\Module\User\Infrastructure\UI\Controller;

use BetaReaders\Module\User\Domain\User;
use BetaReaders\Module\User\Test\Stub\UserStub;
use BetaReaders\Tests\Module\User\Infrastructure\PHPUnit\UserAcceptanceTestCase;

final class RegisterUserControllerAcceptanceTest extends UserAcceptanceTestCase
{
    /**
     * @test
     */
    public function itShouldRegisterAnUserWithSuccess(): void
    {
        // Given
        $randomUser = UserStub::random();
        $randomUserJson = $this->jsonApiFromUser($randomUser);

        // When
        $this->httpPost($this->route('/v1/users'), $randomUserJson);

        // Then
        $this->thenTheResponseCodeShouldBe(201);
        $expectedUser = UserStub::withRegistrationRoles($randomUser);
        $this->thenUserShouldMatchWithTheStoredOnes($expectedUser);
    }

    /**
     * @test
     */
    public function itShouldNotRegisterAnUserAlreadyRegistered(): void
    {
        // Given
        $randomUser = UserStub::random();
        $this->givenUsers($randomUser);
        $randomUserJson = $this->jsonApiFromUser($randomUser);

        // When
        $this->httpPost($this->route('/v1/users'), $randomUserJson);

        // Then
        $this->thenTheResponseCodeShouldBe(409);
    }

    /**
     * @test
     *
     * @dataProvider constrainedUsersProvider
     */
    public function itShouldNotRegisterAnUserIfTheEmailIsAlreadyTaken(User $randomUser, User $userToCreate): void
    {
        // Given
        $this->givenUsers($randomUser);
        $randomUserJson = $this->jsonApiFromUser($userToCreate);

        // When
        $this->httpPost($this->route('/v1/users'), $randomUserJson);

        // Then
        $this->thenTheResponseCodeShouldBe(400);
    }
}
