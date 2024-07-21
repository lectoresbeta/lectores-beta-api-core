<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Domain\Bus\Query\Response;

use function Lambdish\Phunctional\get;

use Neomerx\JsonApi\Schema\Error;

final class JsonApiThrowableResponse implements Response
{
    public function __construct(private readonly \Throwable $error)
    {
    }

    public function toPlain(): array
    {
        $error = $this->createBasicError();
        $error->setMeta($this->metadataFromError());

        return [$error];
    }

    private function createBasicError(): Error
    {
        $error = new Error();
        $error
            ->setDetail($this->error->getMessage())
            ->setCode($this->code());

        return $error;
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
