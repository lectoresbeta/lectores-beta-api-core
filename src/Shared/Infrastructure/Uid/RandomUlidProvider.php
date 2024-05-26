<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Uid;

use BetaReaders\Shared\Domain\Uid\Ulid;
use BetaReaders\Shared\Domain\Uid\UlidProvider;
use Ulid\Ulid as BaseUlid;

final class RandomUlidProvider implements UlidProvider
{
    public function new(): Ulid
    {
        return new Ulid(BaseUlid::generate()->__toString());
    }
}
