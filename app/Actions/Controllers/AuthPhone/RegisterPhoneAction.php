<?php

namespace App\Actions\Controllers\AuthPhone;

use App\Contracts\Actions\Controllers\AuthPhoneController\LoginPhoneActionContract;
use App\Contracts\Actions\Controllers\AuthPhoneController\RegisterPhoneActionContract;
use App\Http\Requests\AuthPhone\RegisterRequest;
use App\Http\Resources\AuthPhone\Login\SuccessLoginPhoneResource;
use App\Models\User;
use Str;

class RegisterPhoneAction implements RegisterPhoneActionContract
{
    public function __construct(private LoginPhoneActionContract $action)
    {}

    public function __invoke(RegisterRequest $request):  SuccessLoginPhoneResource
    {
        $user = User::create([
            'name' => uniqid('user_phone'),
            'email' => uniqid('email_phone@'),
            'password' => Str::random(),
        ])->phone()->create([
            'number' => $request->number,
            'last_num' => substr($request->number, -4),
        ]);
        if (!$request->callback) {
            return $this->action->send($request->number);
        } else {
            return $this->action->sendCallback($request->number);
        }
    }
}
