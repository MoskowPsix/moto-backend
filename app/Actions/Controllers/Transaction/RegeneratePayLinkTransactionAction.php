<?php

namespace App\Actions\Controllers\Transaction;

use \App\Contracts\Actions\Controllers\Transaction\RegeneratePayLinkTransactionActionContract;
use App\Contracts\Services\PaymentServiceContract;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Http\Requests\Transaction\RegeneratePayLinkRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Transaction\Create\SuccessCreateTransactionResource;
use App\Models\Transaction;
use Carbon\Carbon;


class RegeneratePayLinkTransactionAction implements \App\Contracts\Actions\Controllers\Transaction\RegeneratePayLinkTransactionActionContract
{
    public function __construct(private PaymentServiceContract $paymentServiceContract)
    {}

    public function __invoke(int $id, RegeneratePayLinkRequest $request): SuccessCreateTransactionResource|NotFoundResource
    {
        if (!Transaction::where('id', $id)->exists()) {
            return NotFoundResource::make([]);
        }
        $transaction = Transaction::find($id);
        isset($request->isRace) ?
            ($link = $this->paymentServiceContract->generateLinkForRace($transaction)) :
            ($link = $this->paymentServiceContract->generateLinkForTrack($transaction));

        $transaction->link = $link;

        return new SuccessCreateTransactionResource($transaction);
    }
}
