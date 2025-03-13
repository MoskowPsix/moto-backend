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
        Log::info('Robokassa SuccessUrl request received:', $request->all());

        $outSum = $request->input("OutSum");
        $invId = $request->input("InvId");
        $crc = strtoupper($request->input('SignatureValue'));

        if (!$invId) {
            Log::error('InvId is missing in the request');
            return response('InvId is missing', 400);
        }

        $transaction = Transaction::find($invId);
        if (!$transaction) {
            Log::error("Transaction not found for InvId: $invId");
            return response("Transaction not found for InvId: $invId", 404);
        }
        $attendance = $transaction->attendances()->first();
        if (!$attendance) {
            Log::error("Attendance not found for transaction: $invId");
            return response("Attendance not found for transaction: $invId", 400);
        }
        $store = $attendance->track()->first()->store()->first();

        $password_1 = $store->password_1;
        Log::info($password_1);
        $myCrc = strtoupper(md5("$outSum:$invId:$password_1"));

        if ($myCrc !== $crc) {
            Log::error("Invalid signature for transaction: $invId");
        }
        Log::info("Transaction result for InvId: $invId");
        return response("Спасибо за использование нашего сервиса", 200);
    }
}
