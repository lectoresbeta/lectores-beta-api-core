<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Test\Stub;

use Faker\Factory;
use Faker\Generator;

final class StubCreator
{
    private static ?Generator $faker = null;

    public static function random(): Generator
    {
        return self::faker();
    }

    public static function faker(): Generator
    {
        return self::$faker = self::$faker ?: Factory::create();
    }
}
