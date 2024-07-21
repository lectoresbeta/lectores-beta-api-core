<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use Symfony\Component\HttpFoundation\Response;

final class JsonApiOffsetLimitPaginatedResponse extends JsonApiPaginatedResponse
{
    public function __construct(
        string $type,
        private readonly int $offset,
        private readonly int $limit,
        int $totalResults,
        array $data = [],
        int $statusCode = Response::HTTP_OK,
        array $headers = []
    ) {
        parent::__construct($type, $totalResults, $data, $statusCode, $headers);
    }

    public function metadata(): array
    {
        return array_merge(
            parent::metadata(),
            [
                'offset' => $this->offset,
                'limit' => $this->limit,
            ]
        );
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
