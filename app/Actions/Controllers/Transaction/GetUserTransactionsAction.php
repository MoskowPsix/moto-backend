<?php

namespace App\Actions\Controllers\Transaction;

use App\Contracts\Actions\Controllers\Transaction\GetUserTransactionsActionContract;
use App\Http\Requests\User\GetUserTransactionsRequest;
use App\Http\Resources\Transaction\GetTransactions\SuccessGetUserTransactionsResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class GetUserTransactionsAction implements GetUserTransactionsActionContract
{
    public function __invoke(GetUserTransactionsRequest $request): SuccessGetUserTransactionsResource
    {
        $page = $request->page ?? 1;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 10;
        $sort = $request->sort ?? 'desc';
        $sortField = $request->sortField ?? 'created_at';

        $transactions = Transaction::where('user_id', Auth::id())->with('attendances')
            ->orderBy($sortField, $sort);

        if ($request->paginate) {
            $transactions = $transactions->paginate($limit, ['*'], 'page', $page);
        } else {
            $transactions = $transactions->get();
        }
        return SuccessGetUserTransactionsResource::make($transactions);
    }
}
