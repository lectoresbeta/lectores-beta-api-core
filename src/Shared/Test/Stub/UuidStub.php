<?php
declare(strict_types=1);

namespace BetaReaders\Shared\Test\Stub;

use BetaReaders\Shared\Domain\Uid\Uuid;

final class UuidStub
{
    public static function random(): Uuid
    {
        $stubCreator = StubCreator::random();
        return new Uuid($stubCreator->uuid());
    }

    public static function with(string $value): Uuid
    {
        return new Uuid($value);
    }
}