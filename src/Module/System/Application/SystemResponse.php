<?php

namespace BetaReaders\Module\System\Application;

use BetaReaders\Shared\Domain\Bus\Query\Response;

class SystemResponse implements Response
{
    public function __construct(private readonly string $id, private readonly bool $result)
    {
    }

    public static function withId(string $id): SystemResponse
    {
        return new self($id, true);
    }

    public function toPlain(): array
    {
        return [
            'id' => $this->id,
            'result' => $this->result,
        ];
    }
}
