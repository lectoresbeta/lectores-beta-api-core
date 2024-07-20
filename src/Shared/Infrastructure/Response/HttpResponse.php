<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response;

/**
 * @template T
 */
interface HttpResponse
{
    /**
     * @return T
     */
    public function data(): mixed;

    public function statusCode(): int;

    public function headers(): array;
}
