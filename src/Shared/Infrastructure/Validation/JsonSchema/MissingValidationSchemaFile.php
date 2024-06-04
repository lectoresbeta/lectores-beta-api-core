<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Validation\JsonSchema;

use BetaReaders\Shared\Domain\Exception\CriticalException;

final class MissingValidationSchemaFile extends CriticalException
{
    private const MESSAGE = 'Unable to find the validation schema file.';

    public static function withFilepath(string $path): self
    {
        return self::withMessageAndExtraItems(self::MESSAGE, ['json_schema_path' => $path]);
    }
}
