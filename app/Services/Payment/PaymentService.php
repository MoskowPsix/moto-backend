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
}
