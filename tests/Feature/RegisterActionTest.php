<?php

namespace Tests\Feature;

use App\Contracts\Actions\Auth\LoginActionContract;
use App\Contracts\Actions\Auth\RegisterActionContract;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\Register\ErrorRegisterResource;
use App\Http\Resources\Auth\Register\SuccessRegisterResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    use RefreshDatabase;
    public function test_action_successful(): void
    {
        $user = ([
            'email' => 'test@test.com',
            'password' => '1234',
            'name' => 'Test User',
        ]);
        $request = new RegisterRequest($user);
        $action = app(RegisterActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(SuccessRegisterResource::class, $userAction);
        $this->assertEquals($user['email'], $userAction->email);
    }
    public function test_action_email_failed(): void{
        $user = ([
            'email' => null,
            'password' => '1234',
            'name' => 'Test User',
        ]);
        $request = new RegisterRequest($user);
        $action = app(RegisterActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(ErrorRegisterResource::class, $userAction);
    }

//    public function test_action_password_failed(): void{
//        $user = ([
//            'email' => 'test@test.com',
//            'password' => null,
//            'name' => 'Test User',
//        ]);
//        $request = new RegisterRequest($user);
//        $action = app(RegisterActionContract::class);
//        $userAction = $action($request);
//
//        $this->assertInstanceOf(ErrorRegisterResource::class, $userAction);
//    }

    public function test_action_name_failed(): void{
        $user = ([
            'email' => 'test@test.com',
            'password' => '1234',
            'name' => null,
        ]);
        $request = new RegisterRequest($user);
        $action = app(RegisterActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(ErrorRegisterResource::class, $userAction);
    }
}
