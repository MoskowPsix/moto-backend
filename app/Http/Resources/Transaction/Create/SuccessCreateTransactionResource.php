<?php

namespace App\Http\Resources\Transaction\Create;

use App\Http\Resources\Transaction\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $link
 */
class SuccessCreateTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'        => 'success',
            'message'       => __('messages.transaction.create.success'),
            'payment_link'   => $this->link,
            'transaction'   => TransactionResource::make($this->resource)
        ];
    }
}
