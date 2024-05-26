<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Bus\Query;

interface Response
{
    public function toPlain(): array;
}
