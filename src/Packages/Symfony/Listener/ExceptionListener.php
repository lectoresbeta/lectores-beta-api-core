<?php

namespace BetaReaders\Packages\Symfony\Listener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
    }
}
