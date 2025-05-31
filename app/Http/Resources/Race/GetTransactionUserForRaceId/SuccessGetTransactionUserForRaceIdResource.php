<?php

namespace App\Http\Resources\Race\GetTransactionUserForRaceId;

use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetTransactionUserForRaceIdResource extends JsonResource
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
            'message' => __('messages.race.get_transaction_user_for_race_id.success'),
            'transactions' => $this->resource instanceof Transaction ? TransactionResource::make($this->resource) : TransactionResource::collection($this->resource)
        ];
    }
}
