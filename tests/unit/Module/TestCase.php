<?php

declare(strict_types=1);

namespace BetaReaders\Tests\Module;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @template T
     *
     * @param class-string<T> $className
     *
     * @return T
     */
    protected function mock(string $className): object
    {
        /** @var T|MockInterface $mock */
        $mock = \Mockery::mock($className);

        return $mock;
    }

    protected function tearDown(): void
    {
        \Mockery::close();

        parent::tearDown();
    }
}
