<?php

declare(strict_types=1);

namespace BetaReaders\Module\System\Application\Get;

use BetaReaders\Module\System\Application\SystemResponse;
use BetaReaders\Shared\Domain\Uid\UlidProvider;

final class GetSystemStatusQueryHandler
{
    public function __construct(private readonly UlidProvider $ulidProvider)
    {
    }

    public function __invoke(GetSystemStatusQuery $query): SystemResponse
    {
        return SystemResponse::withId($this->ulidProvider->new()->value());
    }
}
