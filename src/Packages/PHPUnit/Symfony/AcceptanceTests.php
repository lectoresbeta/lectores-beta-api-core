<?php

declare(strict_types=1);

namespace BetaReaders\Packages\PHPUnit\Symfony;

use BetaReaders\Kernel;

use function BetaReaders\Utils\jsonDeserialize;
use function BetaReaders\Utils\jsonSerialize;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

abstract class AcceptanceTests extends WebTestCase
{
    use Arrangeable;

    protected KernelBrowser $client;

    protected const HTTP_HEADERS = [
        'CONTENT_TYPE' => 'application/json',
        'HTTP_ACCEPT' => 'application/json',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient(server: self::HTTP_HEADERS);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->arrange();
    }

    protected function httpGet(string $url, array $parameters = []): ?array
    {
        $this->client->request(
            Request::METHOD_GET,
            $url,
            $parameters
        );

        $response = $this->client->getResponse();

        return jsonDeserialize($response->getContent());
    }

    protected function httpPost(string $url, array $content = []): ?array
    {
        $this->client->request(
            Request::METHOD_POST,
            $url,
            content: jsonSerialize($content)
        );

        $response = $this->client->getResponse();

        return jsonDeserialize($response->getContent());
    }

    protected function httpPut(string $url, array $content = []): ?array
    {
        $this->client->request(
            Request::METHOD_PUT,
            $url,
            content: jsonSerialize($content)
        );

        $response = $this->client->getResponse();

        return jsonDeserialize($response->getContent());
    }

    protected static function createKernel(array $options = []): Kernel
    {
        $env = $options['environment'] ?? 'test';
        return new Kernel($env, true);
    }

    protected function route(string $root, ?string $path = null): string
    {
        if (!empty($path) && !str_starts_with($path, '/') && !str_starts_with($path, '?')) {
            $path = '/'.$path;
        }

        if (str_ends_with($root, '/')) {
            $root = rtrim($root, '/');
        }

        return $root.($path ?? null);
    }

    protected function container(): Container
    {
        return $this->getContainer();
    }
}
