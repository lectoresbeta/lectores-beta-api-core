<?php

namespace BetaReaders\Packages\Symfony\Listener;

use BetaReaders\Shared\Infrastructure\Entrypoint\Http\HttpExceptionsHandler;
use BetaReaders\Shared\Infrastructure\Response\HttpResponseEncoder;
use BetaReaders\Shared\Infrastructure\Response\JsonApi\JsonApiErrorResponse;
use BetaReaders\Shared\Infrastructure\Response\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    public function __construct(
        private readonly HttpExceptionsHandler $exceptionHandler,
        private readonly HttpResponseEncoder $errorResponseEncoder,
        private readonly ResponseFactory $responseFactory,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $this->prepareHttpResponse($exception, $event);
    }

    private function prepareHttpResponse(\Throwable $exception, ExceptionEvent $event): void
    {
        $existsInExceptionHandler = $this->exceptionHandler->exists(get_class($exception));
        $mappedStatusCode = $this->exceptionHandler->statusCode(get_class($exception));

        switch (true) {
            case $existsInExceptionHandler:
                $result = JsonApiErrorResponse::fromException($exception, $mappedStatusCode);
                $body = $this->errorResponseEncoder->encode($result);
                $response = $this->responseFactory->create($body, $result->statusCode(), $result->headers());
                break;
            default:
                $response = $this->makeUnhandledExceptionResponse($exception);
        }

        $event->setResponse($response);
    }

    private function makeUnhandledExceptionResponse(\Throwable $exception): Response
    {
        $error = ($prev = $exception->getPrevious()) instanceof \Throwable ? $prev : $exception;
        $result = JsonApiErrorResponse::fromException($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        $body = $this->errorResponseEncoder->encode($result);

        return $this->responseFactory->create($body, $result->statusCode(), $result->headers());
    }
}
