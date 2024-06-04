<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Test\Comparator;

use BetaReaders\Shared\Domain\Aggregate\AggregateRoot;
use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Exporter\Exporter;
use function BetaReaders\Tests\isSimilar;

final class AggregateRootSimilarComparator extends Comparator
{
    public function accepts(mixed $expected, mixed $actual): bool
    {
        return $expected instanceof AggregateRoot
            && $actual instanceof AggregateRoot
            && (method_exists($expected, 'pullEvents') || method_exists($actual, 'pullEvents'));
    }

    public function assertEquals(mixed $expected, mixed $actual, float $delta = 0.0, bool $canonicalize = false, bool $ignoreCase = false): void
    {
        $exporter = new Exporter();
        $actualEntity = clone $actual;
        $actualEntity->pullEvents();

        if (!$this->aggregateRootsAreSimilar($expected, $actualEntity)) {
            throw new ComparisonFailure($expected, $actual, $exporter->export($expected), $exporter->export($actual), 'Failed asserting the aggregate roots are equal.');
        }
    }

    private function aggregateRootsAreSimilar(AggregateRoot $expected, AggregateRoot $actual): bool
    {
        if (!$this->aggregateRootsAreTheSameClass($expected, $actual)) {
            return false;
        }

        return $this->aggregateRootPropertiesAreSimilar($expected, $actual);
    }

    private function aggregateRootsAreTheSameClass(AggregateRoot $expected, AggregateRoot $actual): bool
    {
        return get_class($expected) === get_class($actual);
    }

    private function aggregateRootPropertiesAreSimilar(AggregateRoot $expected, AggregateRoot $actual): bool
    {
        $expectedReflected = new \ReflectionObject($expected);
        $actualReflected = new \ReflectionObject($actual);

        foreach ($expectedReflected->getProperties() as $expectedReflectedProperty) {
            $actualReflectedProperty = $actualReflected->getProperty($expectedReflectedProperty->getName());

            $expectedReflectedProperty->setAccessible(true);
            $actualReflectedProperty->setAccessible(true);

            $expectedProperty = $expectedReflectedProperty->getValue($expected);
            $actualProperty = $actualReflectedProperty->getValue($actual);

            if (!isSimilar($expectedProperty, $actualProperty)) {
                return false;
            }
        }

        return true;
    }
}
