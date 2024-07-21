<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Response\JsonApi;

interface JsonApiSchemaRegisterer
{
    public function registerer(): \Closure;
}
