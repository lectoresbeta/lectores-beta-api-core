<?php
declare(strict_types=1);

namespace BetaReaders\Module\User\Test\Stub;

use BetaReaders\Shared\Domain\User\Email;
use BetaReaders\Shared\Test\Stub\StubCreator;

final class EmailStub
{
    public static function random(): Email
    {
        return new Email(StubCreator::random()->email());
    }
}