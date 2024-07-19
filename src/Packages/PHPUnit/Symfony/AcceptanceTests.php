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
    use HasDoctrine;
    use HasHttpAssertions;

    protected ?KernelBrowser $client = null;

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
        try {
            $this->arrange();
            parent::tearDown();
            $this->ensureKernelShutdown();
        } catch (\Throwable) {
            parent::tearDown();
            $this->ensureKernelShutdown();
        }
    }

    protected function httpGet(string $url, array $parameters = []): ?array
    {
        $this->httpClient()->request(
            Request::METHOD_GET,
            $url,
            $parameters
        );

        $content = $this->httpClient()->getResponse()->getContent();
        $response = false === $content ? '' : $content;

        return jsonDeserialize($response);
    }

    protected function httpPost(string $url, array $content = []): ?array
    {
        $this->httpClient()->request(
            Request::METHOD_POST,
            $url,
            content: jsonSerialize($content)
        );

        $content = $this->httpClient()->getResponse()->getContent();
        $response = false === $content ? '' : $content;

        return jsonDeserialize($response);
    }

    protected function httpPut(string $url, array $content = []): ?array
    {
        $this->httpClient()->request(
            Request::METHOD_PUT,
            $url,
            content: jsonSerialize($content)
        );

        $content = $this->httpClient()->getResponse()->getContent();
        $response = false === $content ? '' : $content;

        return jsonDeserialize($response);
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

    private function httpClient(): KernelBrowser
    {
        if (null === $this->client) {
            throw new \RuntimeException('You must set up the application before, client is closed by default.');
        }

        return $this->client;
    }
}
