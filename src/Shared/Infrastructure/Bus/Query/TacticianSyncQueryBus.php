<?php
declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Bus\Query;

use BetaReaders\Shared\Domain\Bus\Query\Query;
use BetaReaders\Shared\Domain\Bus\Query\QueryBus;
use BetaReaders\Shared\Domain\Bus\Query\Response;
use League\Tactician\CommandBus as TacticianBus;

final class TacticianSyncQueryBus implements QueryBus
{
    public function __construct(private readonly TacticianBus $bus)
    {
    }

    public function ask(Query $query): ?Response
    {
        return $this->bus->handle($query);
    }
}