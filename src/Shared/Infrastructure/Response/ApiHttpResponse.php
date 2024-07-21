<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * @template T
 */
abstract class ApiHttpResponse implements HttpResponse
{
    /**
     * @param T|null $data
     */
    public function __construct(
        protected mixed $data = null,
        protected int $statusCode = Response::HTTP_OK,
        protected array $headers = [],
    ) {
    }

    /**
     * @return T|null
     */
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
