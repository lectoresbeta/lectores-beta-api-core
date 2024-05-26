<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Bus\Query;

interface QueryBus
{
    /**
     * @template T of Response|null
     *
     * @param Query<T> $query
     *
     * @return T
     */
    public function ask(Query $query): ?Response;
}
