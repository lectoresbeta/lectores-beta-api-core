<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response;

interface HttpResponseEncoder
{
    public function encode(HttpResponse $response): string;
}
