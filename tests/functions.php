<?php

declare(strict_types=1);

namespace BetaReaders\Tests;

use BetaReaders\Shared\Test\SimilarConstraint;
use BetaReaders\Shared\Test\SimilarMatcher;

function isSimilar(mixed $expected, mixed $value, float $delta = 0.0, bool $canonicalize = false, bool $ignoreCase = false): bool
{
    $evaluation = false;
    $constraint = new SimilarConstraint($expected, $delta, $canonicalize, $ignoreCase);

    if ($result = $constraint->evaluate($value, '', true)) {
        $evaluation = $result;
    }

    return $evaluation;
}

function similarTo(
    mixed $value,
    float $delta = 0.0,
    bool $canonicalize = false,
    bool $ignoreCase = false
): SimilarMatcher {
    return SimilarMatcher::create($value, $delta, $canonicalize, $ignoreCase);
}
