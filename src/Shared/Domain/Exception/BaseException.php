<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Exception;

abstract class BaseException extends \Exception
{
    final public function __construct(
        string $message,
        int $code,
        ?\Throwable $previous = null,
        protected array $extraItems = []
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function withMessageAndExtraItems(string $message, array $extraItems): static
    {
        return new static($message, 0, null, $extraItems);
    }

    public function extraItems(): array
    {
        return $this->extraItems;
    }
}
