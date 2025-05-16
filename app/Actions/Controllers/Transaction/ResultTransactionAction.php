<?php

namespace App\Actions\Controllers\Transaction;

use App\Contracts\Actions\Controllers\Transaction\ResultTransactionActionContract;
use App\Http\Requests\Transaction\ResultTransactionRequest;
use App\Models\Cards;
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
        $opKey = $request->input('Token');

        if (!$invId) {
            return response('InvId is missing', 400);
        }

        $transaction = Transaction::find($invId);
        if (!$transaction) {
            return response("Transaction not found for InvId: $invId", 404);
        }

        $attendance = $transaction->attendances()->first();
        if (!$attendance) {
            return response("Attendance not found for transaction: $invId", 400);
        }

        $store = $attendance->track()->first()->store()->first();
        $password_2 = $store->password_2;

        $myCrc = strtoupper(md5("$outSum:$invId:$password_2"));

        if ($myCrc !== $crc) {
            return response("Invalid signature for transaction: $invId", 400);
        }
        $transaction->update([
            'data' => $request->except('SignatureValue'),
        ]);

        if($opKey && !$transaction->user->cards()->exists()) {
            Cards::create([
                'user_id' => $transaction->user->id,
                'op_key'  => $opKey,
            ]);
        }

        return response("OK$invId\n", 200);
    }
}

