<?php

namespace App\Contracts\Actions\Controllers\RecoveryPassword;

use App\Http\Requests\RecoveryPassword\SendRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\RecoveryPassword\Send\SuccessSendRecoveryPasswordResource;

interface SendRecoveryPasswordActionContract
{
    public function __invoke(SendRequest $request): NotFoundResource | SuccessSendRecoveryPasswordResource;

}
