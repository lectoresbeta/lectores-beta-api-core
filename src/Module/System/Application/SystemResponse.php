<?php

declare(strict_types=1);

namespace BetaReaders\Module\System\Application;

use BetaReaders\Shared\Domain\Bus\Query\Response;

final class SystemResponse implements Response
{
    public function __construct(private readonly string $id, private readonly bool $result)
    {
    }

    public static function withId(string $id): self
    {
        return new self($id, true);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function toPlain(): array
    {
        return [
            'result' => $this->result,
        ];
    }
}
