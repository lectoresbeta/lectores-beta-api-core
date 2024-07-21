<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Domain\Exception\CriticalException;

final class ResourceSchemaNotFound extends CriticalException
{
    private const MESSAGE = 'Unregistered resource schema detected';

    public static function withResourceClass(string $resourceClass): self
    {
        return self::withMessageAndExtraItems(self::MESSAGE, ['resource_class' => $resourceClass]);
    }
}
