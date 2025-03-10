<?php

namespace App\Contracts\Actions\Controllers\Store;

use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Resources\Store\Create\SuccessCreateStoreResource;

interface CreateStoreActionContract
{
    public function __invoke(CreateStoreRequest $request): SuccessCreateStoreResource;
}
