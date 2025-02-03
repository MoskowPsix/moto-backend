<?php

namespace Auth;

use App\Contracts\Actions\Auth\RegisterActionContract;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\Register\ErrorRegisterResource;
use App\Http\Resources\Auth\Register\SuccessRegisterResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;
    public function test_action_successful(): void
    {
        $user = User::factory()->make()->toArray();
        $request = new RegisterRequest($user);
        $action = app(RegisterActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(SuccessRegisterResource::class, $userAction);
        $this->assertEquals($user['email'], $userAction->email);
    }
    public function test_action_email_failed(): void{
        $user = User::factory()->make([
            'email' => null,
        ])->toArray();
        $request = new RegisterRequest($user);
        $action = app(RegisterActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(ErrorRegisterResource::class, $userAction);
    }

    public function test_action_name_failed(): void{
        $user = User::factory()->make([
            'name' => null,
        ])->toArray();
        $request = new RegisterRequest($user);
        $action = app(RegisterActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(ErrorRegisterResource::class, $userAction);
    }
}
