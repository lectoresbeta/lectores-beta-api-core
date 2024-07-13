<?php

declare(strict_types=1);

namespace BetaReaders\Tests\Module\User\Infrastructure\PHPUnit;

use BetaReaders\Module\User\Domain\User;
use BetaReaders\Packages\PHPUnit\Symfony\AcceptanceTests;
use Doctrine\ORM\EntityManagerInterface;

abstract class UserAcceptanceTestCase extends AcceptanceTests
{
    protected function givenUsers(User ...$users): void
    {
        $this->container()->get(EntityManagerInterface::class);
    }
}
