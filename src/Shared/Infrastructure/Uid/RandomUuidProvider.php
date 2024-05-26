<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Uid;

use BetaReaders\Shared\Domain\Uid\Uuid;
use BetaReaders\Shared\Domain\Uid\UuidProvider;
use Ramsey\Uuid\Uuid as BaseUuid;

final class RandomUuidProvider implements UuidProvider
{
    public function new(): Uuid
    {
        return new Uuid(BaseUuid::uuid4()->toString());
    }
}
