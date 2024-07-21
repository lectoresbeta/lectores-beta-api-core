<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Domain\Exception\CriticalException;

final class SchemaResourceAlreadyRegistered extends CriticalException
{
    private const MESSAGE = 'Schema resource is already registered';

    public static function withResourceAndSchema(string $resourceClass, string $schemaClass): self
    {
        return self::withMessageAndExtraItems(self::MESSAGE, [
            'resource_class' => $resourceClass,
            'schema_class' => $schemaClass,
        ]);
    }
}
