<?php

declare(strict_types=1);

namespace BetaReaders\Tests;

use BetaReaders\Shared\Test\SimilarConstraint;
use BetaReaders\Shared\Test\SimilarMatcher;

function isSimilar($expected, $value, $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false): bool
{
    $constraint = new SimilarConstraint($expected, $delta, $maxDepth, $canonicalize, $ignoreCase);

    return $constraint->evaluate($value, '', true);
}

function similarTo(
    $value,
    $delta = 0.0,
    $maxDepth = 10,
    $canonicalize = false,
    $ignoreCase = false
): SimilarMatcher {
    return SimilarMatcher::create($value, $delta, $maxDepth, $canonicalize, $ignoreCase);
}
