<?php

namespace App\Contracts\Actions\Controllers\Version;

use App\Http\Resources\Version\GetFirst\SuccessGetFirstVersionResource;

interface GetVersionActionContract
{
    public function __invoke(): SuccessGetFirstVersionResource;
}
