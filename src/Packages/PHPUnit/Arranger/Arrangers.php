<?php

declare(strict_types=1);

namespace BetaReaders\Packages\PHPUnit\Arranger;

final class Arrangers extends \ArrayIterator
{
    /**
     * @var Arranger[]
     */
    private array $arrangers;

    public function __construct(\Traversable $arrangers)
    {
        $this->arrangers = iterator_to_array($arrangers);
        parent::__construct($this->arrangers);
    }
}
