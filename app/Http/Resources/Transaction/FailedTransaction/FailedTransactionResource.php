<?php

namespace App\Http\Resources\Transaction\FailedTransaction;

use App\Http\Resources\Transaction\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FailedTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'failed',
            'message' => __('messages.transaction.failed'),
        ];
    }
}
