<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Infrastructure\Response\JsonApi;

use BetaReaders\Shared\Infrastructure\Response\JsonApi\JsonApiSchemaMapping;
use BetaReaders\Shared\Infrastructure\Response\JsonApi\JsonApiSchemaRegisterer;

final class UserJsonApiSchemaRegisterer implements JsonApiSchemaRegisterer
{
    public function registerer(): \Closure
    {
        return function (JsonApiSchemaMapping $mapping): void {};
    }
}
