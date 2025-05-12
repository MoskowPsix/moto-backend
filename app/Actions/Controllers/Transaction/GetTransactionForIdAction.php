<?php

namespace App\Actions\Controllers\Transaction;

use App\Contracts\Actions\Controllers\Transaction\GetTransactionForIdActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Transaction\GetForId\SuccessGetTransactionForIdResource;
use App\Models\Transaction;

class GetTransactionForIdAction implements GetTransactionForIdActionContract
{
    public function __invoke(int $id):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessGetTransactionForIdResource
    {
        $transaction = Transaction::where('id', $id);

        if(!$transaction->exists()) {
            return NotFoundResource::make([]);
        }
        $transaction = $transaction->with('attendances.track', 'user')->first();
        if ($transaction->user_id !== auth()->user()->id) {
            return NotUserPermissionResource::make([]);
        }

        return SuccessGetTransactionForIdResource::make($transaction);
    }
}
