<?php

declare(strict_types=1);

namespace BetaReaders\Packages\Doctrine\DBAL\Type;

use BetaReaders\Shared\Domain\Uid\Ulid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;

final class UlidType extends StringType
{
    private const NAME = 'ulid_type';

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Ulid
    {
        if (null === $value || $value instanceof Ulid) {
            return $value;
        }

        if (!\is_string($value)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Ulid::class, 'string']);
        }

        return new Ulid($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Ulid) {
            try {
                return (new Ulid($value))->value();
            } catch (\Throwable) {
                throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Ulid::class]);
            }
        }

        return $value->value();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
