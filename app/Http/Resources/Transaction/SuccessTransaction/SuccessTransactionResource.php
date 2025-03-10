<?php

namespace App\Http\Resources\Transaction\SuccessTransaction;

use App\Http\Resources\Transaction\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'success',
            'message' => __('messages.transaction.success'),
            'transaction' => TransactionResource::make($this->resource)
        ];
    }
}
