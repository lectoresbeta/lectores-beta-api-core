<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Test;

use BetaReaders\Shared\Test\Comparator\AggregateRootSimilarComparator;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

final class SimilarConstraint extends Constraint
{
    public function __construct(
        private readonly mixed $value,
        private readonly float $delta = 0.0,
        private readonly bool $canonicalize = false,
        private readonly bool $ignoreCase = false
    ) {
    }

    public function evaluate(mixed $other, string $description = '', bool $returnResult = false): ?bool
    {
        $isValid = true;
        $comparatorFactory = new Factory();

        $comparatorFactory->register(new AggregateRootSimilarComparator());

        try {
            $comparator = $comparatorFactory->getComparatorFor($other, $this->value);

            $comparator->assertEquals($this->value, $other, $this->delta, $this->canonicalize, $this->ignoreCase);
        } catch (ComparisonFailure $f) {
            if (!$returnResult) {
                throw new ExpectationFailedException(trim($description."\n".$f->getMessage()), $f);
            }

            $isValid = false;
        }

        return $isValid;
    }

    public function toString(): string
    {
        return self::class;
    }
}
