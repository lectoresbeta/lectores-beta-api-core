<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Uid;

interface UuidProvider
{
    public function new(): Uuid;
}
