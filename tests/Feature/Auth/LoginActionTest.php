<?php

namespace Auth;

use App\Contracts\Actions\Controllers\Auth\LoginActionContract;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\Login\ErrorLoginResource;
use App\Http\Resources\Auth\Login\SuccessLoginResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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

//    public function test_action_throw_exception(): void
//    {
//        $pass = fake()->password();
//        $user = User::factory()->create([
//            'password' => Hash::make($pass),
//        ]);
//
//        $request = new LoginRequest([
//            'password' => '',
//            'email' => $user->email,
//        ]);
//        $action = app(LoginActionContract::class);
//        $response = $action($request);
//
//        $this->assertInstanceOf(ErrorLoginResource::class, $response);
//
//        $this->assertEquals('Неверные учетные данные.', $response->resource['Login failed']);
//
//    }

}
