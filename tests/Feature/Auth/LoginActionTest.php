<?php

namespace Auth;

use App\Contracts\Actions\Controllers\Auth\LoginActionContract;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\Login\ErrorLoginResource;
use App\Http\Resources\Auth\Login\SuccessLoginResource;
use App\Http\Resources\Error\Login\ErrorEmailExistsResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Exception;

class LoginActionTest extends TestCase
{
    /**
     * @throws Exception
     */
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_action_successful(): void
    {
        $pass = fake()->password();
        $user = User::factory()->create([
            'password' => Hash::make($pass),
            'deleted_at' => now(),
        ]);
        $user_login =   [
            'email'       => $user->email,
            'password'    => $pass,
        ];

        $request = new LoginRequest($user_login);
        $action = app(LoginActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(SuccessLoginResource::class, $userAction);
        $this->assertEquals($user->id, $userAction->resource->id);
    }

    public function test_action_password_failed(): void
    {
        $pass = fake()->password();
        $user = User::factory()->create([
            'password' => Hash::make($pass),
        ]);
        $user_login =   [
            'email'       => $user->email,
            'password'    => null,
        ];
        $request = new LoginRequest($user_login);
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

        $this->assertInstanceOf(ErrorEmailExistsResource::class, $userAction);
    }
}
