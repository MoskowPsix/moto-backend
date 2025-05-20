<?php

namespace App\Actions\Controllers\Transaction;

use App\Contracts\Actions\Controllers\Transaction\ResultTransactionActionContract;
use App\Http\Requests\Transaction\ResultTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Log;

class ResultTransactionAction implements ResultTransactionActionContract
{
    public function __invoke(Request $request)
    {
        $outSum = $request->input('OutSum');
        $invId = $request->input('InvId');
        $crc = strtoupper($request->input('SignatureValue'));

        if (!$invId) {
            Log::error('InvId is missing in the request');
        }

        $transaction = Transaction::find($invId);
        if (!$transaction) {
            Log::error("Transaction not found for InvId: $invId");
        }

        $attendance = $transaction->attendances()->first();
        if (!$attendance) {
            Log::error("Attendance not found for transaction: $invId");
        }

        $store = $attendance->track()->first()->store()->first();
        $password_2 = $store->password_2;

        $myCrc = strtoupper(md5("$outSum:$invId:$password_2"));

        if ($myCrc !== $crc) {
            Log::error("Invalid signature for transaction: $invId");
        }
        $transaction->update([
            'data' => $request->except('SignatureValue'),
            'status' => true,
        ]);
        Log::info('Success');
        Log::info("Transaction result for InvId: $invId");
        return response("OK$invId\n", 200);
    }
}

