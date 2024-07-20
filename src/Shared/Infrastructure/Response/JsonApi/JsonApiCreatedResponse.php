<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use Symfony\Component\HttpFoundation\Response;

final class JsonApiCreatedResponse extends JsonApiResponse
{
    public function __construct(array $headers = [])
    {
        parent::__construct(Response::HTTP_CREATED, null, $headers);
    }
}
