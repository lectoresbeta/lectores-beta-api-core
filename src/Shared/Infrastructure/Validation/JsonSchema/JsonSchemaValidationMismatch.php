<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Validation\JsonSchema;

use BetaReaders\Shared\Domain\Exception\BaseException;

final class JsonSchemaValidationMismatch extends BaseException
{
    private const MESSAGE = 'Invalid content provided against schema.';

    public static function withErrors(array $errors): self
    {
        return self::withMessageAndExtraItems(self::MESSAGE, $errors);
    }
}
