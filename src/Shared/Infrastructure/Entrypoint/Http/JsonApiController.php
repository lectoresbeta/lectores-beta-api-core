<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Entrypoint\Http;

use BetaReaders\Shared\Domain\Bus\Command\Command;
use BetaReaders\Shared\Domain\Bus\Command\CommandBus;
use BetaReaders\Shared\Domain\Bus\Query\Query;
use BetaReaders\Shared\Domain\Bus\Query\QueryBus;
use BetaReaders\Shared\Domain\Bus\Query\Response;
use BetaReaders\Shared\Infrastructure\Validation\JsonSchema\JsonSchemaGuard;
use BetaReaders\Shared\Infrastructure\Validation\JsonSchema\JsonSchemaValidationMismatch;
use BetaReaders\Shared\Infrastructure\Validation\JsonSchema\MissingValidationSchemaFile;

use function Lambdish\Phunctional\each;

abstract class JsonApiController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
        private readonly JsonSchemaGuard $bodyGuard,
        private readonly HttpExceptionsHandler $exceptionHandler
    ) {
        each($this->exceptionRegistry(), $this->exceptions());
    }

    /**
     * @return array<class-string<\Throwable>, int>
     */
    abstract protected function exceptions(): array;

    /**
     * @template T of Response|null
     *
     * @param Query<T> $query
     *
     * @return T
     */
    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    /**
     * @throws MissingValidationSchemaFile
     * @throws JsonSchemaValidationMismatch
     */
    protected function guardJsonSchema(array $content, string $schemaId): void
    {
        $this->bodyGuard->guard($content, $schemaId);
    }

    private function exceptionRegistry(): callable
    {
        return function (int $httpCode, string $exception) {
            $this->exceptionHandler->register($exception, $httpCode);
        };
    }
}
