<?php

declare(strict_types=1);

namespace BetaReaders\Module\System\Infrastructure\Response\JsonApi;

use BetaReaders\Module\System\Application\SystemResponse;
use BetaReaders\Shared\Infrastructure\Response\JsonApi\JsonApiSchemaMapping;
use BetaReaders\Shared\Infrastructure\Response\JsonApi\JsonApiSchemaRegisterer;

final class SystemJsonApiSchemaRegisterer implements JsonApiSchemaRegisterer
{
    public function registerer(): \Closure
    {
        return function (JsonApiSchemaMapping $mapping): void {
            $mapping->add(SystemResponse::class, SystemResponseJsonApiSchema::class);
        };
    }
}
