<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Uid;

interface UlidProvider
{
    public function new(): Ulid;
}
