<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Validation\JsonSchema;

use Opis\JsonSchema\Validator;
use Symfony\Component\Filesystem\Filesystem;

final class JsonSchemaGuard
{
    private const MAX_ERRORS = 5;

    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly string $schemasRootPath,
        private readonly JsonSchemaErrorFormatter $formatter,
        private readonly int $maxErrors = self::MAX_ERRORS
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
        $contentAsObject = json_decode(json_encode($content) ?: '');

        $validator = new Validator();
        $validator->setMaxErrors($this->maxErrors);

        $validator->resolver()?->registerFile($schemaId, $realSchemaPath);
        $validation = $validator->validate($contentAsObject, $schemaId);

        if (!$validation->isValid() && ($validationError = $validation->error())) {
            $errors = $this->formatter->format($validationError);
            throw JsonSchemaValidationMismatch::withErrors($errors);
        }
    }

    private function fetchSchemaRealPath(string $schemaFilePath): string
    {
        $schemaExists = is_file($schemaFilePath) || $this->filesystem->exists($schemaFilePath);

        if ($schemaExists && ($schemaPath = realpath($schemaFilePath)) !== false) {
            return $schemaPath;
        }

        throw MissingValidationSchemaFile::withFilepath($schemaFilePath);
    }
}
