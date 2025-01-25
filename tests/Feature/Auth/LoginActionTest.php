<?php

namespace Auth;

use App\Contracts\Actions\Auth\LoginActionContract;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\Login\ErrorLoginResource;
use App\Http\Resources\Auth\Login\SuccessLoginResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginActionTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_action_successful(): void
    {
        $user = User::factory()->create();

        $request = new LoginRequest($user);
        $action = app(LoginActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(SuccessLoginResource::class, $userAction);
        $this->assertEquals($user->id, $userAction->resource->id);
    }

    public function test_action_password_failed(): void
    {
        $request = new LoginRequest([
            'password' => fake()->password(),
            'email' => fake()->email()
        ]);
        $action = app(LoginActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(ErrorLoginResource::class, $userAction);
    }
    public function test_action_email_failed(): void
    {
        $request = new LoginRequest([
            'password' => fake()->password(),
            'email' => fake()->email()
        ]);
        $action = app(LoginActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(ErrorLoginResource::class, $userAction);
    }
}
