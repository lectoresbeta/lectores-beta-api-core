<?php

declare(strict_types=1);

namespace BetaReaders\Module\System\Infrastructure\Response\JsonApi;

use BetaReaders\Module\System\Application\SystemResponse;
use Neomerx\JsonApi\Contracts\Schema\ContextInterface;
use Neomerx\JsonApi\Contracts\Schema\SchemaInterface;
use Neomerx\JsonApi\Schema\BaseSchema;

final class SystemResponseJsonApiSchema extends BaseSchema implements SchemaInterface
{
    public function getType(): string
    {
        return 'healthcheck';
    }

    /**
     * @param SystemResponse $resource
     */
    public function getId($resource): ?string
    {
        return $resource->id();
    }

    /**
     * @param SystemResponse $resource
     */
    public function getAttributes($resource, ContextInterface $context): iterable
    {
        return $resource->toPlain();
    }

    public function getRelationships($resource, ContextInterface $context): iterable
    {
        return [];
    }

    public function getLinks($resource): iterable
    {
        return [];
    }
}
