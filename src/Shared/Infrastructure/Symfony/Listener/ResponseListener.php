<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Symfony\Listener;

use BetaReaders\Shared\Infrastructure\Response\ApiHttpResponse;
use BetaReaders\Shared\Infrastructure\Response\JsonApi\JsonApiResponse;
use BetaReaders\Shared\Infrastructure\Response\JsonApi\JsonApiResponseEncoder;
use BetaReaders\Shared\Infrastructure\Response\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;

final class ResponseListener
{
    public function __construct(
        private readonly JsonApiResponseEncoder $encoder,
        private readonly ResponseFactory $responseFactory
    ) {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $result = $event->getControllerResult();

        if ($result instanceof JsonApiResponse) {
            $response = $this->encoder->encode($result);
            $jsonResponse = $this->responseFactory->create($response, $result->statusCode(), $result->headers());
            $event->setResponse($jsonResponse);

            return;
        }

        if ($result instanceof ApiHttpResponse) {
            $apiResponse = new Response(
                $result->data(),
                $result->statusCode(),
                $result->headers()
            );
            $event->setResponse($apiResponse);
        }
    }
}
