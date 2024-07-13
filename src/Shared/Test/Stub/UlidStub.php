<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Test\Stub;

use Ulid\Ulid;

final class UlidStub
{
    public static function random(): Ulid
    {
        return Ulid::generate();
    }
}
