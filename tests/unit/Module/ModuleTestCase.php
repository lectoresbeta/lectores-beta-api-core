<?php

declare(strict_types=1);

namespace BetaReaders\Tests\Module;

use BetaReaders\Shared\Domain\Bus\Command\Command;
use BetaReaders\Shared\Domain\Bus\Command\CommandBus;
use BetaReaders\Shared\Domain\Bus\Query\Query;
use BetaReaders\Shared\Domain\Bus\Query\QueryBus;
use BetaReaders\Shared\Domain\Bus\Query\Response;
use Mockery\MockInterface;

abstract class ModuleTestCase extends TestCase
{
    protected QueryBus|MockInterface|null $queryBus = null;
    protected CommandBus|MockInterface|null $commandBus = null;

    protected function queryBus(): QueryBus|MockInterface
    {
        return $this->queryBus = $this->queryBus ?: $this->mock(QueryBus::class);
    }

    protected function commandBus(): CommandBus|MockInterface
    {
        return $this->commandBus = $this->commandBus ?: $this->mock(CommandBus::class);
    }

    protected function dispatch(Command $command, callable $handler): void
    {
        $handler($command);
    }

    protected function ask(Query $query, callable $handler): ?Response
    {
        return $handler($query);
    }

    protected function askThrowsException(string $exceptionClass, Query $query, callable $handler): void
    {
        $this->expectException($exceptionClass);

        $this->ask($query, $handler);
    }

    protected function dispatchAndThrowException(Command $command, callable $handler, string $exceptionClass): void
    {
        $this->expectException($exceptionClass);

        $handler($command);
    }
}
