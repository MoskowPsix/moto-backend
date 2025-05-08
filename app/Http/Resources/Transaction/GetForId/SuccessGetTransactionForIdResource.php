<?php

namespace App\Http\Resources\Transaction\GetForId;

use App\Http\Resources\Transaction\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetTransactionForIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'    => 'success',
            'message' => __('messages.transaction.get_for_id.success'),
            'transaction' => TransactionResource::make($this->resource),
        ];
    }
}
