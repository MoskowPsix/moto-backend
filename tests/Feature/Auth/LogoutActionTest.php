<?php

namespace Auth;

use App\Contracts\Actions\Controllers\Auth\LogoutActionContract;
use App\Http\Resources\Auth\Logout\ErrorLogoutResource;
use App\Http\Resources\Auth\Logout\SuccessLogoutResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutActionTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_action_error(): void
    {
        $logoutAction = app(LogoutActionContract::class);
        $response = $logoutAction();
        $this->assertEquals(ErrorLogoutResource::make([]), $response);

    }

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $logoutAction = app(LogoutActionContract::class);
        $response = $logoutAction();

        $this->assertInstanceOf(SuccessLogoutResource::class, $response);
    }
}
