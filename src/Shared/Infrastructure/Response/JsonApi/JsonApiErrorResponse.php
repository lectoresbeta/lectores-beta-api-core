<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Domain\Bus\Query\Response;

final class JsonApiErrorResponse extends JsonApiResponse
{
    public function __construct(int $code, ?Response $data = null, array $headers = [])
    {
        parent::__construct($code, $data, $headers);
    }

    public static function fromException(\Throwable $exception, int $code, array $headers = []): self
    {
        return new self($code, new JsonApiBridgeErrorResponse($exception), $headers);
    }
}
