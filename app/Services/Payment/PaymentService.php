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

        $receipt = [
            'sno' => 'usn_income',
            'items' => [],
        ];
        foreach ($attendances as $attendance) {
            $receipt['items'][] = [
                'name'      => $attendance->name,
                'quantity'  => 1,
                'sum'       => $attendance->price,
                'tax'       => $attendance->tax ?? 'none',
            ];
        }

        $jsonString = json_encode($receipt, JSON_UNESCAPED_UNICODE);
        $encodedReceipt = urlencode($jsonString);

        $crc = md5("$login:$outSum:$invoiceId:$encodedReceipt:$password");

        $path = http_build_query([
            'MerchantLogin'     => $login,
            'OutSum'            => $outSum,
            'InvId'             => $invoiceId,
            'Desc'              => $description,
            'SignatureValue'    => strtoupper($crc),
            'IsTest'            => $IsTest,
            'Receipt'           => $encodedReceipt,
        ]);
        return "https://auth.robokassa.ru/Merchant/Index.aspx?" . $path;
    }
}
