<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonResponseFactory implements ResponseFactory
{
    public function __construct(private readonly int $encodingOptions = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    {
    }

    public function create(mixed $data, int $statusCode, array $headers = []): JsonResponse
    {
        $response = match (true) {
            is_string($data) => JsonResponse::fromJsonString($data, $statusCode, $headers),
            default => new JsonResponse($data, $statusCode, $headers),
        };

        $response->setEncodingOptions($this->encodingOptions);

        return $response;
    }
}
