<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Infrastructure\UI\Controller;

use BetaReaders\Module\User\Application\Register\RegisterUserCommand;
use BetaReaders\Module\User\Domain\UnexpectedUserStoringError;
use BetaReaders\Module\User\Domain\UserAlreadyExist;
use BetaReaders\Shared\Infrastructure\Entrypoint\Http\JsonApiController;
use BetaReaders\Shared\Infrastructure\Response\JsonApi\JsonApiCreatedResponse;

use function Lambdish\Phunctional\get_in;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RegisterUserController extends JsonApiController
{
    private const JSON_SCHEMA_ID = 'register_user.schema.json';

    protected function exceptions(): array
    {
        return [
            UserAlreadyExist::class => Response::HTTP_BAD_REQUEST,
            UnexpectedUserStoringError::class => Response::HTTP_CONFLICT,
        ];
    }

    public function __invoke(Request $request): JsonApiCreatedResponse
    {
        $body = $request->request->all();
        $this->guardJsonSchema($body, self::JSON_SCHEMA_ID);

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

        $this->dispatch($command);

        return new JsonApiCreatedResponse();
    }
}
