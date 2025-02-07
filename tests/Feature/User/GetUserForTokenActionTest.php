<?php

namespace Tests\Feature\User;

use App\Contracts\Actions\Auth\LogoutActionContract;
use App\Contracts\Actions\User\GetUserForTokenActionContract;
use App\Http\Resources\Auth\Logout\SuccessLogoutResource;
use App\Http\Resources\PersonalInfo\PersonalInfoResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;
use App\Models\User;
use Google\Service\Iam\Role;
use Google\Service\ServiceControl\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetUserForTokenActionTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $logoutAction = app(GetUserForTokenActionContract::class);
        $response = $logoutAction();

        $this->assertInstanceOf(SuccessLogoutResource::class, $response);
    }
}
