<?php
declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Bus\Command;

use BetaReaders\Shared\Domain\Bus\Command\Command;
use BetaReaders\Shared\Domain\Bus\Command\CommandBus;
use League\Tactician\CommandBus as TacticianBus;

final class TacticianSyncCommandBus implements CommandBus
{
    public function __construct(private readonly TacticianBus $bus)
    {
    }

    public function dispatch(Command $command): void
    {
        $this->bus->handle($command);
    }
}