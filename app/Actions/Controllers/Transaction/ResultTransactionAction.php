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
        Log::info('Robokassa ResultUrl request:', [
            'OutSum' => $request->input('OutSum'),
            'InvId' => $request->input('InvId'),
            'SignatureValue' => $request->input('SignatureValue'),
        ]);

        $outSum = $request->input('OutSum');
        $invId = $request->input('InvId');
        $crc = strtoupper($request->input('SignatureValue'));

        $transaction = Transaction::find($invId);
        if (!$transaction) {
            Log::error("Transaction not found for InvId: $invId");
            http_response_code(404);
        }

        $attendance = $transaction->attendances()->first();
        if (!$attendance) {
            Log::error("Attendance not found for transaction: $invId");
            http_response_code(400);
        }

        $store = $attendance->track()->first()->store()->first();
        $password_2 = $store->password_2;

        $myCrc = strtoupper(md5("$outSum:$invId:$password_2"));

        if ($myCrc !== $crc) {
            Log::error("Invalid signature for transaction: $invId");
            http_response_code(400);
        }
        Log::info('Success');
        echo "OK$invId\n";
        exit;
    }
}

