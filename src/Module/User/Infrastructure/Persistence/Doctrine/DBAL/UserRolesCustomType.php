<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Infrastructure\Persistence\Doctrine\DBAL;

use BetaReaders\Shared\Domain\User\UserRoles;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;

final class UserRolesCustomType extends JsonType
{
    public const NAME = 'user_roles_custom_type';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): UserRoles
    {
        $value = parent::convertToPHPValue($value, $platform);

        return UserRoles::fromPlain($value);
    }

    /**
     * @param UserRoles|null $value
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return parent::convertToDatabaseValue($value?->toArray() ?? [], $platform);
    }
}
