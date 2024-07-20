<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response;

use Symfony\Component\HttpFoundation\Response;

interface ResponseFactory
{
    public function create(mixed $data, int $statusCode, array $headers = []): Response;
}
