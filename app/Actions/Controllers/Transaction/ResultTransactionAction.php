<?php

namespace App\Actions\Controllers\Transaction;

use App\Contracts\Actions\Controllers\Transaction\ResultTransactionActionContract;
use App\Http\Requests\Transaction\ResultTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Log;

class ResultTransactionAction implements ResultTransactionActionContract
{
    public function handleResult(Request $request)
    {
        Log::info('Robokassa Result Request:', $request->all());

        $invoiceId = $request->input('InvId');
        $outSum = $request->input('OutSum');
        $signature = $request->input('SignatureValue');

        $transaction = Transaction::findOrFail($invoiceId);

        $store = $transaction->attendance()->first()->track()->first()->store();
        $password = $store->password_2;
        $expectedSignature = strtoupper(md5("$outSum:$invoiceId:$password"));

        if ($expectedSignature === strtoupper($signature)) {
            $transaction->update(['status' => true]);

            return response('OK', 200);
        }

        return response('Invalid signature', 400);
    }
}

