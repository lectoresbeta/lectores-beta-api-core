<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Infrastructure\Response\ApiHttpResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class JsonApiPaginatedResponse extends ApiHttpResponse
{
    protected const COUNT_KEY = 'count';

    public function __construct(
        protected readonly string $type,
        protected readonly int $totalResults,
        array $data = [],
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
    ) {
        parent::__construct($data, $statusCode, $headers);
    }

    public function metadata(): array
    {
        return [
            self::COUNT_KEY => $this->totalResults,
        ];
    }

    public function items(): array
    {
        return $this->data;
    }

    public function totalResults(): int
    {
        return $this->totalResults;
    }

    public function type(): string
    {
        return $this->type;
    }
}
