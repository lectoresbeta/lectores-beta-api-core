<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Test;

use Mockery\Matcher\MatcherInterface;

final class SimilarMatcher implements MatcherInterface
{
    private readonly SimilarConstraint $constraint;

    private function __construct($value, $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
    {
        $this->constraint = new SimilarConstraint(
            $value,
            $delta,
            $maxDepth,
            $canonicalize,
            $ignoreCase
        );
    }

    public static function create($value, $delta = 0.0, $maxDepth = 20, $canonicalize = false, $ignoreCase = false): self
    {
        return new self($value, $delta, $maxDepth, $canonicalize, $ignoreCase);
    }

    public function match(&$actual): bool
    {
        return $this->constraint->evaluate($actual, '', true);
    }

    public function __toString(): string
    {
        return 'SimilarMatcher';
    }
}
