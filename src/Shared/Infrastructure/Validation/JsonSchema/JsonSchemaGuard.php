<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Validation\JsonSchema;

use Opis\JsonSchema\Validator;
use Symfony\Component\Filesystem\Filesystem;

final class JsonSchemaGuard
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly string $schemasRootPath
    ) {
    }

    /**
     * @throws JsonSchemaValidationMismatch|MissingValidationSchemaFile
     */
    public function guard(array $content, string $schemaId): void
    {
        $schemaPath = $this->schemasRootPath.DIRECTORY_SEPARATOR.$schemaId;
        $realSchemaPath = $this->fetchSchemaRealPath($schemaPath);

        $schemaId = sprintf('file://%s', $realSchemaPath);
        $contentAsObject = json_decode(json_encode($content));

        $validator = new Validator();
        $validator->resolver()->registerFile($schemaId, $realSchemaPath);
        $validation = $validator->validate($contentAsObject, $schemaId);

        if (!$validation->isValid()) {
            throw JsonSchemaValidationMismatch::withErrors([]);
        }
    }

    private function fetchSchemaRealPath(string $schemaFilePath): string
    {
        if (is_file($schemaFilePath)) {
            return realpath($schemaFilePath);
        }

        if (!$this->filesystem->exists($schemaFilePath)) {
            throw MissingValidationSchemaFile::withFilepath($schemaFilePath);
        }

        return realpath($schemaFilePath);
    }
}
