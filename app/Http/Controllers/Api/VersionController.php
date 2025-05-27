<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Version\GetVersionActionContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\verificationEmail\Send\SuccessSendVerificationEmailResource;
use App\Http\Resources\Version\GetFirst\SuccessGetFirstVersionResource;
use App\Models\Version;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'VersionController', description: 'Подтверждение почты через письмо')]
class VersionController extends Controller
{
    #[ResponseFromApiResource(SuccessGetFirstVersionResource::class)]
    #[Endpoint(title: 'get', description: 'Получение последней версий приложения')]
    public function get(GetVersionActionContract $action): SuccessGetFirstVersionResource
    {
        return $action();
    }
}
