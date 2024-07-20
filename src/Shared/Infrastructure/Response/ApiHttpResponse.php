<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response;

use Symfony\Component\HttpFoundation\Response;

abstract class ApiHttpResponse implements HttpResponse
{
    public function __construct(
        protected mixed $data = null,
        protected int $statusCode = Response::HTTP_OK,
        protected array $headers = [],
    ) {
    }

    public function data(): mixed
    {
        return $this->data;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function headers(): array
    {
        return $this->headers;
    }
}
