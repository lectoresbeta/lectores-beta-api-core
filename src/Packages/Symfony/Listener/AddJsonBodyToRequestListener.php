<?php

declare(strict_types=1);

namespace BetaReaders\Packages\Symfony\Listener;

use function BetaReaders\Utils\jsonDeserialize;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class AddJsonBodyToRequestListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $requestContents = $request->getContent();

        if (
            empty($requestContents)
            && ($contentType = $request->headers->get('Content-Type'))
            && !str_starts_with('application/json', $contentType)
            || Request::METHOD_GET === $request->getMethod()
        ) {
            return;
        }

        $jsonData = $this->jsonOrFail($request);

        if (
            ($contentType = $request->headers->get('Content-Type'))
            && !str_starts_with('application/json', $contentType)
        ) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Invalid content type');
        }

        $jsonDataLowerCase = [];

        foreach ($jsonData as $key => $value) {
            if (is_int($key)) {
                break;
            }

            $jsonDataLowerCase[preg_replace_callback(
                '/_(.)/',
                static fn ($matches) => strtoupper($matches[1]),
                $key
            )] = $value;
        }

        $request->request->replace($jsonDataLowerCase);
    }

    private function jsonOrFail(Request $request): array
    {
        try {
            return jsonDeserialize($request->getContent());
        } catch (\Throwable) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Invalid json data');
        }
    }
}
