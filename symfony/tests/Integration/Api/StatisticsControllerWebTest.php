<?php

namespace App\Tests\Integration\Api;

use App\Tests\Integration\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * @covers  \App\Controller\SmsController
 */
class StatisticsControllerWebTest extends BaseWebTestCase
{
    private KernelBrowser $client;
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /**
     * @covers \App\Controller\StatisticsController::statisticsByProviders()
     * @dataProvider \App\Tests\Integration\Api\DataProvider\StatisticsDataProvider::statisticsByProvidersProvider()
     */
    public function testStatisticsByProvidersProvider(array $params, array $expected): void
    {
        $this->client->request('POST', '/api/statistics/by-providers', $params);

        $this->assertResponseStatusCodeSame($expected['code'], $this->client->getResponse()->getStatusCode());
    }
}