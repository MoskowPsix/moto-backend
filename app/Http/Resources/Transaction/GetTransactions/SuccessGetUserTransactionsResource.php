<?php

namespace App\Http\Resources\Transaction\GetTransactions;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetUserTransactionsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'status' => 'success',
            'message' => __('messages.transaction.get_users.success'),
            'transactions' => $this->resource instanceof Transaction ? \App\Http\Resources\Transaction\TransactionResource::make($this->resource) : \App\Http\Resources\Transaction\TransactionResource::collection($this->resource)
        ];
    }
}
