<?php

namespace App\Actions\Controllers\Transaction;

use App\Contracts\Actions\Controllers\Transaction\SuccessTransactionActionContract;
use App\Http\Requests\Transaction\SuccessTransactionRequest;
use App\Http\Resources\Transaction\SuccessTransaction\SuccessTransactionResource;
use App\Models\Transaction;

class SuccessTransactionAction implements SuccessTransactionActionContract
{
    public function __invoke(SuccessTransactionRequest $request): SuccessTransactionResource
    {
        $password = env('ROBOKASSA_TEST_PASSWORD1');

        $outSum = $request->input("OutSum");
        $invId = $request->input("InvId");
        $crc = $request->input("SignatureValue");

        $transaction = Transaction::findOrFail($invId);

        $crc = strtoupper($crc);
        $checkCrc = strtoupper(md5("$outSum:$invId:$password"));

        if ($crc === $checkCrc) {
            $transaction->update(['status' => 'complete']);
        }
        return SuccessTransactionResource::make($transaction);
    }
}
