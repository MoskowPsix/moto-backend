<?php

namespace App\Actions\Controllers\Transaction;

use App\Contracts\Actions\Controllers\Transaction\CreateTransactionActionContract;
use App\Contracts\Services\PaymentServiceContract;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Http\Resources\Transaction\Create\SuccessCreateTransactionResource;
use App\Models\Attendance;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class CreateTransactionAction implements CreateTransactionActionContract
{
    public function __construct(private PaymentServiceContract $paymentServiceContract)
    {}

    public function __invoke(CreateTransactionRequest $request): SuccessCreateTransactionResource
    {
        $transaction = Transaction::create([
            'user_id'       => auth()->user()->id,
            'date'          => Carbon::now(),
            'status'        => null,
        ]);
        $transaction->attendances()->attach($request->attendanceIds);

        isset($request->isRace) ?
            ($link = $this->paymentServiceContract->generateLinkForRace($transaction)) :
            ($link = $this->paymentServiceContract->generateLinkForTrack($transaction));

        $transaction->link = $link;

        return new SuccessCreateTransactionResource($transaction);
    }
}
