<?php

namespace App\Services\Payment;

use App\Contracts\Services\SecondCheckServiceContract;
use App\Models\Transaction;

class SecondCheckService implements SecondCheckServiceContract
{

    public function send(Transaction $transaction): array
    {
        $attendance = $transaction->attendances()->first();

        $store = $attendance->track()->first()->store()->first();
        $login = $store->login;
        $password = $store->password_1;

        $attendances = $transaction->attendances;

        $total = $attendances->sum(fn($a) => $a->price);
        $invoiceId = $transaction->id;

        $payload = [
            'merchantId' => $login,
            'id' => $invoiceId + 100000,
            'originId' => $invoiceId,
            'operation' => 'sell',
            'sno' => 'usn_income',
            'url' => 'https://moto.vokrug.city',
            'total' => $total,
            'items' => [],
            'client' => [
                'email' => $transaction->user->email,
                'phone' => $transaction->user->phone,
            ],
            'payments' => [
                [
                    'type' => 2,
                    'sum' => $total
                ]
            ],
            'vats' => []
        ];

        foreach ($attendances as $a) {
            $payload['items'][] = [
                'name' => $a->name,
                'quantity' => 1,
                'sum' => $a->price,
                'tax' => $a->tax ?? 'none',
            ];

            $payload['vats'][] = [
                'type' => $a->tax ?? 'none',
                'sum' => 0
            ];
        }


        $json = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $base64Data = base64_encode($json);

        $signatureBase = $base64Data . $password;
        $md5 = md5($signatureBase);
        $signature = rtrim(base64_encode($md5), '=');

        $postFields = json_encode([
            'data' => $base64Data,
            'signature' => $signature
        ]);

        // Отправка через curl
        $ch = curl_init('https://ws.roboxchange.com/RoboFiscal/Receipt/Attach');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => $postFields,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        return [
            'request_payload' => $payload,
            'request_signature' => $signature,
            'http_code' => $httpCode,
            'response' => json_decode($response, true),
            'error' => $error,
        ];
    }
}
