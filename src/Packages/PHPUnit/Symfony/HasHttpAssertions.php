<?php

declare(strict_types=1);

namespace BetaReaders\Packages\PHPUnit\Symfony;

use PHPUnit\Framework\Assert;

trait HasHttpAssertions
{
    protected function thenTheResponseCodeShouldBe(int $statusCode): void
    {
        Assert::assertEquals($statusCode, $this->client?->getResponse()->getStatusCode());
    }
}
