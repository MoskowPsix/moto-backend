<?php

namespace Auth;

use App\Actions\Auth\LogoutAction;
use App\Contracts\Actions\Auth\LogoutActionContract;
use App\Http\Resources\Auth\Logout\ErrorLogoutResource;
use App\Http\Resources\Auth\Logout\SuccessLogoutResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutActionTest extends TestCase
{
    use RefreshDatabase;

//    protected bool $seed = true;

    public function test_action_error(): void
    {
        $logoutAction = app(LogoutActionContract::class);
        $response = $logoutAction();
        $this->assertEquals(ErrorLogoutResource::make([]), $response);

    }

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $token = auth()->user()->createToken('auth_token')->plainTextToken;
        $logoutAction = app(LogoutActionContract::class);
        $response = $logoutAction();

        $this->assertInstanceOf(SuccessLogoutResource::class, $response);

        $this->assertNull($user->currentAccessToken());
    }
}
