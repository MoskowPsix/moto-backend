<?php

namespace App\Contracts\Actions\Controllers\AuthPhoneController;

use App\Http\Requests\AuthPhone\RegisterRequest;
use App\Http\Requests\AuthPhone\VerifyPhoneRequest;
use App\Http\Resources\Auth\Login\SuccessLoginResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface VerifyPhoneActionContract
{
    public function __invoke(VerifyPhoneRequest $request):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessLoginResource;
}
