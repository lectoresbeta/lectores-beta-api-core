<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Domain\Type\Collection;

use function Lambdish\Phunctional\assoc;
use function Lambdish\Phunctional\dissoc;

abstract class UniqueCollection extends Collection
{
    /**
     * @throws InvalidUniqueIdentifierProperty
     * @throws UniqueIdentifierPropertyAlreadyFilled
     */
    public function __construct(array $items)
    {
        parent::__construct($this->ensureUniqueness($items));
    }

    abstract public function uniqueIdentifier(): \Closure;

    public function element(string $key): mixed
    {
        return $this->items[$key] ?? null;
    }

    /**
     * @throws ElementNotFoundInCollection
     * @throws InvalidUniqueIdentifierProperty
     * @throws UniqueIdentifierPropertyAlreadyFilled
     */
    public function remove(mixed $item): self
    {
        $key = $this->key($item);

        if (!isset($this->items[$key])) {
            throw ElementNotFoundInCollection::default($key);
        }

        /* @phpstan-ignore-next-line */
        return new static(dissoc($this->items, $key));
    }

    /**
     * @throws InvalidUniqueIdentifierProperty
     * @throws UniqueIdentifierPropertyAlreadyFilled
     */
    public function addOrReplace(mixed $item): self
    {
        $key = $this->key($item);

        /* @phpstan-ignore-next-line */
        return new static(assoc($this->items, $key, $item));
    }

    /**
     * @throws InvalidUniqueIdentifierProperty
     * @throws UniqueIdentifierPropertyAlreadyFilled
     */
    protected function ensureUniqueness(array $items): array
    {
        $uniqueItems = [];
        foreach ($items as $item) {
            $key = $this->key($item);

            if (isset($uniqueItems[$key])) {
                throw UniqueIdentifierPropertyAlreadyFilled::default((string) $key);
            }

            $uniqueItems[$key] = $item;
        }

        return $uniqueItems;
    }

    /**
     * @throws InvalidUniqueIdentifierProperty
     */
    private function key(mixed $item): mixed
    {
        $key = ($this->uniqueIdentifier())($item);

        if (empty($key)) {
            throw InvalidUniqueIdentifierProperty::default();
        }

        return $key;
    }
}
