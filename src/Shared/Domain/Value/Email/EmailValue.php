<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Value\Email;

use BetaReaders\Shared\Domain\Value\StringValue;

abstract class EmailValue extends StringValue
{
    /**
     * @throws InvalidEmailException
     */
    protected function guard(): void
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailException::withEmail($this->value);
        }
    }
}
