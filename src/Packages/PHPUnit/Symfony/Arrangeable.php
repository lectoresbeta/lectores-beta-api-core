<?php

declare(strict_types=1);

namespace BetaReaders\Packages\PHPUnit\Symfony;

use BetaReaders\Packages\PHPUnit\Arranger\Arrangers;

trait Arrangeable
{
    public function arrange(): void
    {
        /** @var Arrangers $arrangers */
        $arrangers = $this->container()->get(Arrangers::class);

        foreach ($arrangers as $arranger) {
            $arranger->arrange();
        }
    }
}
