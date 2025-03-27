<?php

namespace Tests\Feature\RecoveryPassword;

use App\Contracts\Actions\Controllers\RecoveryPassword\RecoveryRecoveryPasswordActionContract;
use App\Http\Requests\RecoveryPassword\RecoveryRequest;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\RecoveryPassword\Recovery\SuccessRecoveryRecoveryPasswordResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class RecoveryPasswordActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $tokenData = [$user->id, 'some_data', Carbon::now()->toDateTimeString()];
        $encryptedToken = Crypt::encrypt(implode(',', $tokenData));

        $request = new RecoveryRequest([
            'token' => $encryptedToken,
            'password' => 'newPassword123'
        ]);
        $action = app(RecoveryRecoveryPasswordActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessRecoveryRecoveryPasswordResource::class, $response);
    }

//    public function test_action_not_user_permission(): void
//    {
//        $user = -1;
//        $tokenData = [$user, 'some_data', Carbon::now()->toDateTimeString()];
//        $encryptedToken = Crypt::encrypt(implode(',', $tokenData));
//
//        $request = new RecoveryRequest([
//            'token' => $encryptedToken,
//            'password' => 'newPassword'
//        ]);
//        $action = app(RecoveryRecoveryPasswordActionContract::class);
//        $response = $action($request);
//
//        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
//    }
}
