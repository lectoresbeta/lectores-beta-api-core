<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Infrastructure\Response\ApiHttpResponse;
use Neomerx\JsonApi\Contracts\Encoder\EncoderInterface;
use Neomerx\JsonApi\Encoder\Encoder;
use Symfony\Component\HttpFoundation\RequestStack;

final class JsonApiResponseEncoder
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly JsonApiSchemaMapping $mapping
    ) {
    }

    public function encode(JsonApiResponse $response): string
    {
        $encoder = $this->fetchEncoderBasedOnResponse($response);
        $content = $this->contentByResourceType($response);

        return $encoder->encodeData($content);
    }

    private function fetchEncoderBasedOnResponse(ApiHttpResponse $jsonApiResponse): EncoderInterface
    {
        $responseClass = $this->inferResponseClass($jsonApiResponse);
        $schema = $this->mapping->for($responseClass);

        if (null === $schema && !$this->isNoContentResponse($jsonApiResponse)) {
            throw ResourceSchemaNotFound::withResourceClass($responseClass);
        }

        $includes = $this->fetchIncludesFromRequest();
        $encoder = Encoder::instance($this->mapping->all())->withIncludedPaths($includes);

        if ($jsonApiResponse instanceof JsonApiPaginatedResponse) {
            return $encoder->withMeta($jsonApiResponse->metadata());
        }

        return $encoder;
    }

    private function fetchIncludesFromRequest(): array
    {
        $includes = $this->requestStack->getCurrentRequest()?->get('include', '');

        return array_filter(explode(',', $includes));
    }

    private function inferResponseClass(ApiHttpResponse $response): string
    {
        return $response instanceof JsonApiPaginatedResponse
            ? $response->type()
            : get_class($response);
    }

    private function contentByResourceType(ApiHttpResponse $response): mixed
    {
        return $response instanceof JsonApiPaginatedResponse
            ? $response->items()
            : $response->data();
    }

    private function isNoContentResponse(ApiHttpResponse $response): bool
    {
        return null === $this->contentByResourceType($response);
    }
}
