<?php

namespace App\Console\Commands;

use App\Enums\DocumentType;
use App\Models\Document;
use App\Services\GoogleSheetService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Unetway\LaravelRobokassa\Robokassa;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $code = '2223';
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://restapi.plusofon.ru/api/v1/flash-call/send',
            [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                    'Client'        => env('PLUS_PHONE_CLIENT_ID'),
                    'Authorization' => 'Bearer ' . env('PLUS_PHONE_CALL_KEY'),
                ],
                'json' => [
                    'phone' => '79826190989',
                    'pin' => $code,
                ],
            ]
        );
        $body = $response->getBody();
        $result = json_decode((string) $body);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://restapi.plusofon.ru/api/v1/flash-call/check',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Client' => env('PLUS_PHONE_CLIENT_ID'),
                    'Authorization' => 'Bearer ' . env('PLUS_PHONE_CALLBACK_KEY'),
                ],
                'json' => [
                    'key' => $result->data->key,
                    'pin' => $code,
                ],
            ]
        );
        dd($response);
        $body = $response->getBody();
        dd(json_decode((string) $body));
        return 0;
    }
}
