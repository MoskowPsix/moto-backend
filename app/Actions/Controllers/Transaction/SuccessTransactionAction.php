<?php

namespace App\Actions\Controllers\Transaction;

use App\Contracts\Actions\Controllers\Transaction\SuccessTransactionActionContract;
use App\Http\Resources\Transaction\SuccessTransaction\SuccessTransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Log;

class SuccessTransactionAction implements SuccessTransactionActionContract
{
    public function __invoke(Request $request)
    {

        $outSum = $request->input("OutSum");
        $invId = $request->input("InvId");
        $crc = strtoupper($request->input('SignatureValue'));

        $transaction = Transaction::find($invId);
        $attendance = $transaction->attendances()->first();
        $store = $attendance->track()->first()->store()->first();

        $password_1 = $store->password_1;

        $myCrc = strtoupper(md5("$outSum:$invId:$password_1"));

        if ($myCrc !== $crc) {
            Log::error("Invalid signature for transaction: $invId");
        }
        Log::info("Transaction result for InvId: $invId");
        return response("Спасибо за использование нашего сервиса", 200);
    }
}
