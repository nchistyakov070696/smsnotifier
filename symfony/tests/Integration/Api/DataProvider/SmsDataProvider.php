<?php

namespace App\Tests\Integration\Api\DataProvider;

class SmsDataProvider
{
    public static function sendSmsProvider(): array
    {
        return [
            'success' => [
                'params' => [
                    "accessToken" => "some_hashed_token_0",
                    "phoneNumber" => "+375(29)1111111",
                    "message" => "test_message"
                ],
                'expected' => [
                    'code' => 200,
                ]
            ],
            'failWithWrongAccessToken' => [
                'params' => [
                    "accessToken" => "non_existing_token",
                    "phoneNumber" => "+375(29)1111111",
                    "message" => "test_message"
                ],
                'expected' => [
                    'code' => 422,
                ]
            ],
            'failWithWrongPhoneNumber' => [
                'params' => [
                    "accessToken" => "some_hashed_token_0",
                    "phoneNumber" => "+375(29)11111111",
                    "message" => "test_message"
                ],
                'expected' => [
                    'code' => 422,
                ]
            ],
            'failWithWrongMessage' => [
                'params' => [
                    "accessToken" => "some_hashed_token_0",
                    "phoneNumber" => "+375(29)1111111",
                    "message" => ""
                ],
                'expected' => [
                    'code' => 422,
                ]
            ],
        ];
    }
}
