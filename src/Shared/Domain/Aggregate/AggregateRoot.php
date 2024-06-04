<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Aggregate;

use function Lambdish\Phunctional\any;

abstract class AggregateRoot
{
    protected array $events = [];

    public function raise(DomainEvent $event): void
    {
        if ($this->guardDuplicates($event)) {
            return;
        }

        $this->events[] = $event;
    }

    public function pullEvents(): array
    {
        $domainEvents = $this->events;
        $this->events = [];

        return $domainEvents;
    }

    private function guardDuplicates(DomainEvent $event): bool
    {
        return any(function (DomainEvent $domainEvent) use ($event) {
            return $this->eventAsHash($domainEvent) === $this->eventAsHash($event);
        }, $this->events);
    }

    private function eventAsHash(DomainEvent $event): string
    {
        return serialize([
            'aggregateId' => $event->aggregateId(),
            'eventName' => $event::eventName(),
            'data' => $event->attributes(),
        ]);
    }
}
