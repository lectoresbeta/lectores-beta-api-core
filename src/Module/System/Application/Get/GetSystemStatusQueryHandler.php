<?php

namespace BetaReaders\Module\System\Application\Get;

use BetaReaders\Shared\Domain\Uid\UlidProvider;
use BetaReaders\Module\System\Application\SystemResponse;

class GetSystemStatusQueryHandler
{
    public function __construct(private readonly UlidProvider $ulidProvider)
    {
    }

    public function __invoke(GetSystemStatusQuery $query): SystemResponse
    {
        return SystemResponse::withId($this->ulidProvider->new()->value());
    }

}