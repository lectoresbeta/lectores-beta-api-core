<?php

declare(strict_types=1);

namespace BetaReaders\Tests\Module\User\Infrastructure\UI\Controller;

use BetaReaders\Module\User\Test\Stub\UserStub;
use BetaReaders\Tests\Module\User\Infrastructure\PHPUnit\UserAcceptanceTestCase;

final class RegisterUserControllerAcceptanceTest extends UserAcceptanceTestCase
{
    /**
     * @test
     */
    public function itShouldRegisterAnUserWithSuccess(): void
    {
        $randomUser = UserStub::random();

        $request = $this->httpPost($this->route('/v1/users'), [
            'data' => [
                'id' => $randomUser->id()->value(),
                'type' => 'user',
                'attributes' => [
                    'email' => $randomUser->email()->value(),
                    'username' => $randomUser->username()->value(),
                    'password' => $randomUser->password()->value(),
                ],
            ],
        ]);
    }
}
