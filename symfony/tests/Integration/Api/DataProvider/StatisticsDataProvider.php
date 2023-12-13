<?php

namespace App\Tests\Integration\Api\DataProvider;

class StatisticsDataProvider
{
    public static function statisticsByProvidersProvider(): array
    {
        return [
            'success' => [
                'params' => [
                    "accessToken" => "some_hashed_token_0",
                    "dateFrom" => "2023-12-12 00:00:00",
                    "dateTo" => "2023-12-12 00:00:00",
                ],
                'expected' => [
                    'code' => 200,
                ]
            ],
            'failWithWrongAccessToken' => [
                'params' => [
                    "accessToken" => "non_existing_token",
                    "dateFrom" => "2023-12-12 00:00:00",
                    "dateTo" => "2023-12-12 00:00:00",
                ],
                'expected' => [
                    'code' => 422,
                ]
            ],
            'failWithWrongDateTimeFormat' => [
                'params' => [
                    "accessToken" => "some_hashed_token_0",
                    "dateFrom" => "2023.12.12 00:00:00",
                    "dateTo" => "2023-12-12 00:00:00",
                ],
                'expected' => [
                    'code' => 422,
                ]
            ],
            'failWithWrongDateFromGraterThanDateTo' => [
                'params' => [
                    "accessToken" => "some_hashed_token_0",
                    "dateFrom" => "2023-12-13 00:00:00",
                    "dateTo" => "2023-12-12 00:00:00",
                ],
                'expected' => [
                    'code' => 422,
                ]
            ],
        ];
    }
}
