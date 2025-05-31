<?php

namespace App\Actions\Controllers\Race;

use \App\Contracts\Actions\Controllers\Race\GetTransactionUserForRaceIdActionContract;
use App\Http\Resources\Race\GetTransactionUserForRaceId\SuccessGetTransactionUserForRaceIdResource;
use App\Models\Transaction;


class GetTransactionUserForRaceIdAction implements \App\Contracts\Actions\Controllers\Race\GetTransactionUserForRaceIdActionContract
{
    public function __invoke(int $id): SuccessGetTransactionUserForRaceIdResource
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)->whereHas('attendances', function ($q) use($id) {
            $q->where('race_id', $id);
        });
        return SuccessGetTransactionUserForRaceIdResource::make($transactions->get());
    }
}
