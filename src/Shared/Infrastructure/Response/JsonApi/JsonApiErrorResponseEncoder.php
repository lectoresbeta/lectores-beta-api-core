<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Infrastructure\Response\HttpResponse;
use BetaReaders\Shared\Infrastructure\Response\HttpResponseEncoder;
use Neomerx\JsonApi\Contracts\Encoder\EncoderInterface;
use Neomerx\JsonApi\Encoder\Encoder;

final class JsonApiErrorResponseEncoder implements HttpResponseEncoder
{
    /**
     * @param HttpResponse<JsonApiBridgeErrorResponse> $response
     */
    public function encode(HttpResponse $response): string
    {
        $encoder = $this->createEncoder();
        $data = $response->data();

        return $encoder->encodeErrors($data->toPlain());
    }

    private function createEncoder(): EncoderInterface
    {
        return Encoder::instance();
    }
}
