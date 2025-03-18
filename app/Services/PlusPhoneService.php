<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use PhpParser\JsonDecoder;

class PlusPhoneService
{
    static public function sendCall(int $phone, int $code)
    {
        $client = new \GuzzleHttp\Client();
        $json = [
            'phone' => (string)$phone,
            'pin' => (string)$code,
        ];
            $response = $client->post(
                'https://restapi.plusofon.ru/api/v1/flash-call/send',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Client' => env('PLUS_PHONE_CLIENT_ID'),
                        'Authorization' => 'Bearer ' . env('PLUS_PHONE_CALL_KEY'),
                    ],
                    'json' => $json,
                ]
            );
        $body = $response->getBody();
        return json_decode((string) $body);
    }

    static public function sendCallback(string $phone, string $hook_url): JsonDecoder
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://restapi.plusofon.ru/api/v1/flash-call/call-to-auth',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Client' => env('PLUS_PHONE_CLIENT_ID'),
                    'Authorization' => 'Bearer ' . env('PLUS_PHONE_CALL_KEY'),
                ],
                'json' => [
                    'phone'     => '' . $phone,
                    'hook_url'  => $hook_url,
                ],
            ]
        );
        $body = $response->getBody();
        return json_decode((string) $body);
    }

    static public function checkCall(): JsonDecoder
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://restapi.plusofon.ru/api/v1/flash-call/check',
            [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                    'Client'        => env('PLUS_PHONE_CLIENT_ID'),
                    'Authorization' => 'Bearer ' . env('PLUS_PHONE_CALLBACK_KEY'),
                ],
                'json' => [
                    'key' => 'jplHVYezDwkUTgbvgsNhyhRNnqOzzQXw',
                    'pin' => '3333',
                ],
            ]
        );
        $body = $response->getBody();
        return json_decode((string) $body);
    }
}
