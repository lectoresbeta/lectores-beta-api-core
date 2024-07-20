<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Domain\Bus\Query\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class JsonApiOkResponse extends JsonApiResponse
{
    public function __construct(?Response $data = null, array $headers = [])
    {
        parent::__construct(HttpResponse::HTTP_OK, $data, $headers);
    }
}
