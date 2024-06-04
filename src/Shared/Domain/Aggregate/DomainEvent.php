<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Aggregate;

interface DomainEvent
{
    public function id(): string;

    public static function eventName(): string;

    public function aggregateId(): string;

    public function attributes(): array;

    public function createdAt(): \DateTimeImmutable;
}
