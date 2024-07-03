<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Infrastructure\UI\Controller;

use BetaReaders\Module\User\Application\Register\RegisterUserCommand;
use BetaReaders\Shared\Domain\Bus\Command\CommandBus;
use BetaReaders\Shared\Infrastructure\Validation\JsonSchema\JsonSchemaGuard;

use function Lambdish\Phunctional\get_in;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RegisterUserController
{
    private const JSON_SCHEMA_ID = 'register_user.schema.json';

    public function __construct(
        private readonly JsonSchemaGuard $bodyGuard,
        private readonly CommandBus $bus
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $body = $request->request->all();
        $this->bodyGuard->guard($body, self::JSON_SCHEMA_ID);

        [$userId, $email, $username, $password] = [
            get_in(['data', 'id'], $body),
            get_in(['data', 'attributes', 'email'], $body),
            get_in(['data', 'attributes', 'username'], $body),
            get_in(['data', 'attributes', 'password'], $body),
        ];

        $command = new RegisterUserCommand(
            $userId,
            $email,
            $username,
            $password
        );

        $this->bus->dispatch($command);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
