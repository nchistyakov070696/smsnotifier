<?php

namespace App\Tests\Integration\Api;

use App\Tests\Integration\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * @covers  \App\Controller\SmsController
 */
class SmsControllerWebTest extends BaseWebTestCase
{
    private KernelBrowser $client;
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /**
     * @covers \App\Controller\SmsController::send()
     * @dataProvider \App\Tests\Integration\Api\DataProvider\SmsDataProvider::sendSmsProvider()
     */
    public function testSendMessage(array $params, array $expected): void
    {
        $this->client->request('POST', '/api/sms/send', $params);

        $this->assertResponseStatusCodeSame($expected['code'], $this->client->getResponse()->getStatusCode());
    }
}