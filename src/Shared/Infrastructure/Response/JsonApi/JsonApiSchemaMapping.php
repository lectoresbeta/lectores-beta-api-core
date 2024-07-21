<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use function Lambdish\Phunctional\each;

final class JsonApiSchemaMapping
{
    private static array $mapping = [];

    public function __construct(\Traversable $registrations)
    {
        $registrations = iterator_to_array($registrations);
        each(fn (JsonApiSchemaRegisterer $registerer, int $key) => $registerer->registerer()($this), $registrations);
    }

    public function add(string $responseClass, string $schemaClass): void
    {
        if ($this->exists($responseClass)) {
            return;
        }

        self::$mapping[$responseClass] = $schemaClass;
    }

    public function for(string $responseClass): ?string
    {
        if ($this->exists($responseClass)) {
            return self::$mapping[$responseClass];
        }

        return null;
    }

    public function all(): array
    {
        return self::$mapping;
    }

    private function exists(string $responseClass): bool
    {
        return array_key_exists($responseClass, self::$mapping);
    }
}
