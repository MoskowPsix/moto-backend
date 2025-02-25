<?php

namespace App\Contracts\Actions\Controllers\RecoveryPassword;

use App\Http\Requests\RecoveryPassword\RecoveryRequest;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\RecoveryPassword\Recovery\SuccessRecoveryRecoveryPasswordResource;

interface RecoveryRecoveryPasswordActionContract
{
    public function __invoke(RecoveryRequest $request): NotUserPermissionResource|SuccessRecoveryRecoveryPasswordResource;

}
