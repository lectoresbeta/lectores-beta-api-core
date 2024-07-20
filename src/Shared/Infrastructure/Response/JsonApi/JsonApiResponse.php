<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Domain\Bus\Query\Response;
use BetaReaders\Shared\Infrastructure\Response\ApiHttpResponse;

abstract class JsonApiResponse extends ApiHttpResponse
{
    public function __construct(int $responseCode, ?Response $response = null, array $headers = [])
    {
        parent::__construct($response, $responseCode, $headers);
    }
}
