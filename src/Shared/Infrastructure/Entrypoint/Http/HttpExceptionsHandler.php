<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Entrypoint\Http;

use BetaReaders\Shared\Infrastructure\Validation\JsonSchema\JsonSchemaValidationMismatch;

use function Lambdish\Phunctional\get;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class HttpExceptionsHandler
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    private array $exceptions = [
        NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
        MethodNotAllowedHttpException::class => Response::HTTP_METHOD_NOT_ALLOWED,
        AccessDeniedHttpException::class => Response::HTTP_FORBIDDEN,
        BadRequestHttpException::class => Response::HTTP_BAD_REQUEST,
        \TypeError::class => Response::HTTP_BAD_REQUEST,
        JsonSchemaValidationMismatch::class => Response::HTTP_BAD_REQUEST,
    ];

    public function __construct(array $exceptions = [])
    {
        $this->exceptions = array_merge($this->exceptions, $exceptions);
    }

    public function register(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function exists(string $exceptionClass): bool
    {
        return array_key_exists($exceptionClass, $this->exceptions);
    }

    public function statusCode(string $exceptionClass): int
    {
        return (int) get($exceptionClass, $this->exceptions, self::DEFAULT_STATUS_CODE);
    }
}
