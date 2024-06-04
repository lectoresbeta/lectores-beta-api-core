<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Domain;

use BetaReaders\Shared\Domain\Value\StringValue;

final class Password extends StringValue
{
    private const MIN_LENGTH = 8;

    protected function guard(): void
    {
        if (strlen(trim($this->value)) >= self::MIN_LENGTH) {
            return;
        }

        throw InvalidPasswordProvided::passwordTooShort();
    }

    public static function plain(string $plainPassword): self
    {
        return new self($plainPassword);
    }
}
