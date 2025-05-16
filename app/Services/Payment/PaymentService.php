<?php

namespace App\Services\Payment;

use App\Contracts\Services\PaymentServiceContract;
use App\Models\Transaction;
use Illuminate\Support\Facades\Crypt;

class PaymentService implements PaymentServiceContract
{
    /**
     * @throws \Exception
     */
    public function generateLink(Transaction $transaction): string
    {
        $attendance = $transaction->attendances()->first();

        if (!isset($attendance) || !$attendance->track()->exists()) {
            throw new \Exception('Не удалось найти связанные данные для генерации ссылки.');
        }

        $store = $attendance->track()->first()->store()->first();
        $login = $store->login;
        $password = $store->password_1;

        $attendances = $transaction->attendances;
        $outSum = $attendances->sum(function ($attendance) use ($transaction) {
            return $attendance->price;
        });

        $invoiceId = $transaction->id;
        $description = $attendance->desc ?? 'Оплата услуги';
        $IsTest = 1;
        $crc = md5("$login:$outSum:$invoiceId:$password");

        $path = http_build_query([
            'MerchantLogin'     => $login,
            'OutSum'            => $outSum,
            'InvId'             => $invoiceId,
            'Desc'              => $description,
            'SignatureValue'    => strtoupper($crc),
            'IsTest'            => $IsTest,
        ]);
        return "https://auth.robokassa.ru/Merchant/Index.aspx?" . $path;
    }
    public function generateLinkWithSaveCard(Transaction $transaction, string $opKey): string
    {
        $attendance = $transaction->attendances()->first();

        $store = $attendance->track()->first()->store()->first();
        $login = $store->login;
        $password = $store->password_1;

        $attendances = $transaction->attendances;
        $outSum = $attendances->sum(fn($a) => $a->price);
        $invoiceId = $transaction->id;

        $receipt = [
            'sno' => 'usn_income',
            'items' => [],
        ];
        foreach ($attendances as $attendance) {
            $receipt['items'][] = [
                'name'     => $attendance->name,
                'quantity' => 1,
                'sum'      => $attendance->price,
                'tax'      => $attendance->tax ?? 'none',
            ];
        }
        $jsonString = json_encode($receipt, JSON_UNESCAPED_UNICODE);
        $encodedReceipt = urlencode($jsonString);

        $crcString = "$login:$outSum:$invoiceId:$encodedReceipt:$opKey:$password";
        $signature = md5($crcString);

        $params = http_build_query([
            'MerchantLogin'  => $login,
            'OutSum'         => $outSum,
            'InvId'          => $invoiceId,
            'SignatureValue' => $signature,
            'Receipt'        => $encodedReceipt,
            'Token'          => $opKey,
        ]);

        return "https://auth.robokassa.kz/Merchant/Payment/CoFPayment?" . $params;
    }
}
