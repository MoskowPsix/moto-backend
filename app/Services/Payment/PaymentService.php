<?php

namespace App\Services\Payment;

use App\Contracts\Services\PaymentServiceContract;
use App\Models\Transaction;

class PaymentService implements PaymentServiceContract
{
    private int $IsTest = 0;

    private string $kassaUrl = 'https://auth.robokassa.ru/Merchant/Index.aspx?';

    /**
     * @throws \Exception
     */
    public function generateLinkForRace(Transaction $transaction): string
    {
        if (!$transaction->attendances()->exists()) {
            throw new \Exception('attendances not found');
        }
        $attendance = $transaction->attendances()->first();

        if (!$attendance->race()->exists()) {
            throw new \Exception('track not found');
        }

        if (!$attendance->race()->first()->store()->exists()) {
            throw new \Exception('store not found');
        }

        $store = $attendance->race()->first()->store()->first();
        return $this->generateLink($transaction, $store, $attendance);
    }

    /**
     * @throws \Exception
     */
    public function generateLinkForTrack(Transaction $transaction): string
    {
        if (!$transaction->attendances()->exists()) {
            throw new \Exception('attendances not found');
        }
        $attendance = $transaction->attendances()->first();

        if (!$attendance->track()->exists()) {
            throw new \Exception('track not found');
        }

        if (!$attendance->track()->first()->store()->exists()) {
            throw new \Exception('store not found');
        }

        $store = $attendance->track()->first()->store()->first();
        return $this->generateLink($transaction, $store, $attendance);
    }
    /**
     * @throws \Exception
     */
    private function generateLink(Transaction $transaction, $store, $attendance): string
    {
        $outSum = $transaction->attendances->sum(function ($attendance) use ($transaction) {
            return $attendance->price;
        });

        $receipt = [
            'sno' => $attendance->usn_income_outcome ?? 'usn_income_outcome',
            'items' => $this->createReceiptItems($transaction->attendances),
        ];

        return $this->kassaUrl . $this->generatePath($receipt, $store, $outSum, $transaction);
    }

    private function createReceiptItems($attendances): array
    {
        $receipt = [];
        foreach ($attendances as $attendance) {
            $receipt[] = [
                'name'     => $attendance->name,
                'quantity' => 1,
                'sum'      => $attendance->price,
                'tax'      => $attendance->tax ?? 'none',
            ];
        }
        return $receipt;
    }
    private function generatePath(array $receipt, $store, string $outSum, $transaction): string
    {
        $jsonString = json_encode($receipt, JSON_UNESCAPED_UNICODE);
        $encodedReceipt = urlencode($jsonString);

        $desc = array_map(function($attendance) {
            return $attendance['desc'];
        }, $transaction->attendances->toArray());

        $arr_build_query = [
            'MerchantLogin'     => $store->login,
            'OutSum'            => $outSum,
            'InvId'             => $transaction->id,
            'Description'       => implode(', ', $desc) ?? 'Оплата услуги',
            'Email'             => $transaction->user()->first()->email,
            'IsTest'            => $this->IsTest,
            'Receipt'           => $encodedReceipt,
            'SignatureValue'    => md5("$store->login:$outSum:$transaction->id:$encodedReceipt:$store->password_1"),

        ];
        return http_build_query($arr_build_query);
    }
}
