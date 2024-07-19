<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Test;

use Mockery\Matcher\MatcherInterface;

final class SimilarMatcher implements MatcherInterface
{
    private readonly SimilarConstraint $constraint;

    private function __construct(
        mixed $value,
        float $delta = 0.0,
        bool $canonicalize = false,
        bool $ignoreCase = false,
    ) {
        $this->constraint = new SimilarConstraint(
            $value,
            $delta,
            $canonicalize,
            $ignoreCase
        );
    }

    public static function create(
        mixed $value,
        float $delta = 0.0,
        bool $canonicalize = false,
        bool $ignoreCase = false,
    ): self {
        return new self($value, $delta, $canonicalize, $ignoreCase);
    }

    public function match(&$actual): bool
    {
        return $this->constraint->evaluate($actual, '', true) ?? false;
    }

    public function __toString(): string
    {
        return 'SimilarMatcher';
    }
}
