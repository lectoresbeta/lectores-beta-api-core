<?php

declare(strict_types=1);

namespace BetaReaders\Module\System\Infrastructure\UI\Controller;

use BetaReaders\Module\System\Application\Get\GetSystemStatusQuery;
use BetaReaders\Shared\Infrastructure\Entrypoint\Http\JsonApiController;
use BetaReaders\Shared\Infrastructure\Response\JsonApi\JsonApiOkResponse;
use Symfony\Component\HttpFoundation\Request;

final class GetSystemStatusController extends JsonApiController
{
    protected function exceptions(): array
    {
        return [];
    }

    public function __invoke(Request $request): JsonApiOkResponse
    {
        $response = $this->ask(new GetSystemStatusQuery());

        return new JsonApiOkResponse($response);
    }
}