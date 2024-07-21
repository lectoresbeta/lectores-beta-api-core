<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Validation\JsonSchema;

use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Errors\ValidationError;
use Opis\JsonSchema\JsonPointer;

final class JsonSchemaErrorFormatter
{
    public function format(ValidationError $error): array
    {
        $formatter = new ErrorFormatter();
        $contentFormatter = $this->errorContentFormatter($formatter);

        return $formatter->format(
            error: $error,
            formatter: $contentFormatter,
            key_formatter: $this->errorKeyFormatter()
        );
    }

    private function errorKeyFormatter(): \Closure
    {
        return function (ValidationError $error): string {
            return implode('.', $error->data()->fullPath());
        };
    }

    private function errorContentFormatter(ErrorFormatter $formatter): \Closure
    {
        return function (ValidationError $error) use ($formatter) {
            $schema = $error->schema()->info();

            return [
                'schema' => [
                    'draft' => $schema->draft(),
                    'path' => JsonPointer::pathToFragment($schema->path()),
                    'contents' => $schema->data(),
                ],
                'error' => [
                    'keyword' => $error->keyword(),
                    'args' => $error->args(),
                    'message' => $error->message(),
                    'formatted_message' => $formatter->formatErrorMessage($error),
                ],
                'data' => [
                    'type' => $error->data()->type(),
                    'value' => $error->data()->value(),
                    'full_path' => $error->data()->fullPath(),
                ],
            ];
        };
    }
}
