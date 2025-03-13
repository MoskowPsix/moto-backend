<?php

namespace App\Actions\Controllers\AuthPhone;

use App\Contracts\Actions\Controllers\AuthPhoneController\LoginPhoneActionContract;
use App\Http\Requests\AuthPhone\LoginRequest;
use App\Http\Resources\AuthPhone\Login\SuccessLoginPhoneResource;
use App\Models\PCode;
use App\Models\Phone;
use App\Services\PlusPhoneService;

class LoginPhoneAction implements LoginPhoneActionContract
{
    private readonly PlusPhoneService $plusPhoneService;

    public function __invoke(LoginRequest $request): SuccessLoginPhoneResource
    {
        if (!$request->callback) {
            return $this->send($request->number);
        } else {
            return $this->sendCallback($request->number);
        }
    }
    public function send(int $number): SuccessLoginPhoneResource
    {
        $phone = Phone::where('number', $number)->first();
        $p_code = $this->createPin($phone);
        $plus_response = PlusPhoneService::sendCall($number, $p_code->pin);
        $p_code->update([
            'key' => $plus_response->data->key ?? ''
        ]);
        return SuccessLoginPhoneResource::make([]);
    }
    public function sendCallback(int $number):SuccessLoginPhoneResource
    {
        $plus_response = PlusPhoneService::sendCallback($number, route('user.phone.hook'));
        return SuccessLoginPhoneResource::make([]);
    }
    private function createPin(Phone $phone): PCode
    {
        $pin = fake()->numberBetween(999,10000);
        if ($phone->p_code()->exists()) {
            $phone->p_code()->delete();
        }
        return $phone->p_code()->create([
            'pin' => $pin
        ]);
    }
}
