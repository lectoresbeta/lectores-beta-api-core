<?php

declare(strict_types=1);

namespace BetaReaders\Tests\Module\System\Infrastructure\UI;

use BetaReaders\Packages\PHPUnit\Symfony\AcceptanceTests;
use function Lambdish\Phunctional\get_in;

final class GetSystemStatusControllerAcceptanceTest extends AcceptanceTests
{
    /**
     * @test
     */
    public function itShouldAnswerOkIfTheSystemIsReady(): void
    {
        $response = $this->httpGet($this->route('/system/healthcheck'));
        $this->thenTheResponseCodeShouldBe(200);
        $this->assertTrue(get_in(['data', 'attributes', 'result'], $response));
    }

}
