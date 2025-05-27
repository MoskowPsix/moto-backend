<?php

namespace App\Actions\Controllers\Version;

use \App\Contracts\Actions\Controllers\Version\GetVersionActionContract;
use App\Http\Resources\Version\GetFirst\SuccessGetFirstVersionResource;
use App\Models\Version;


class GetVersionAction implements \App\Contracts\Actions\Controllers\Version\GetVersionActionContract
{
    public function __invoke(): SuccessGetFirstVersionResource
    {
        return SuccessGetFirstVersionResource::make(Version::orderBy('created_at', 'desc')->first());
    }
}
