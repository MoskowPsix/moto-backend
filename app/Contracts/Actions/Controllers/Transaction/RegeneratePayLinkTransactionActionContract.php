<?php

namespace App\Contracts\Actions\Controllers\Transaction;

use App\Http\Requests\Transaction\RegeneratePayLinkRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Transaction\Create\SuccessCreateTransactionResource;

interface RegeneratePayLinkTransactionActionContract
{
    public function __invoke(int $id, RegeneratePayLinkRequest $request): SuccessCreateTransactionResource|NotFoundResource;
}
