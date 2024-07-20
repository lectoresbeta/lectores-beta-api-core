<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Domain\Bus\Query\Response;
use BetaReaders\Shared\Infrastructure\Validation\JsonSchema\JsonSchemaValidationMismatch;

use function Lambdish\Phunctional\get;
use function Lambdish\Phunctional\map;

use Neomerx\JsonApi\Schema\Error;

final class JsonApiBridgeErrorResponse implements Response
{
    public function __construct(private readonly \Throwable $error)
    {
    }

    public function toPlain(): array
    {
        if ($this->error instanceof JsonSchemaValidationMismatch) {
            return map(self::processErrors(), $this->error->extraItems());
        }

        $error = $this->creteBasicError();
        $error->setMeta($this->metadataFromError());

        return [$error];
    }

    private function creteBasicError(): Error
    {
        $error = new Error();
        $error
            ->setDetail($this->error->getMessage())
            ->setCode($this->code());

        return $error;
    }

    private static function processErrors(): callable
    {
        return function (array $error): Error {
            $tmpError = new Error();

            if ($constraint = get('constraint', $error)) {
                $tmpError->setCode((string) $constraint);
            }

            if ($message = get('message', $error)) {
                $tmpError->setDetail((string) $message);
            }

            if ($pointer = get('pointer', $error)) {
                $tmpError->setSource(['pointer' => $pointer]);
            }

            if ($parameter = get('parameter', $error)) {
                $tmpError->setSource(['parameter' => $parameter]);
            }

            if ($property = get('property', $error)) {
                $tmpError->setMeta(['property' => $property]);
            }

            return $tmpError;
        };
    }

    private function code(): string
    {
        if (method_exists($this->error, 'extraItems')
            && ($code = get('code', $this->error->extraItems())) !== null) {
            return (string) $code;
        }

        return (string) $this->error->getCode();
    }

    private function metadataFromError(): array
    {
        if (!method_exists($this->error, 'extraItems') || empty($this->error->extraItems())) {
            return [];
        }

        return $this->error->extraItems();
    }
}
