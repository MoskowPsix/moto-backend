<?php

namespace App\Actions\Controllers\Store;

use App\Contracts\Actions\Controllers\Store\CreateStoreActionContract;
use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Resources\Store\Create\SuccessCreateStoreResource;
use App\Models\Store;

class CreateStoreAction implements CreateStoreActionContract
{
    public function __invoke(CreateStoreRequest $request): SuccessCreateStoreResource
    {
        $store = Store::create([
            'login'         => $request->login,
            'password_1'    => $request->password_1,
            'password_2'    => $request->password_2,
            'token'         => $request->token,
            'user_id'       => auth()->user()->id,
        ]);
        return SuccessCreateStoreResource::make($store);
    }
}
