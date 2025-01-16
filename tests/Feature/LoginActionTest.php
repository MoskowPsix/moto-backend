<?php

namespace Tests\Feature;

use App\Actions\Auth\LoginAction;
use App\Contracts\Actions\Auth\LoginActionContract;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\Login\ErrorLoginResource;
use App\Http\Resources\Auth\Login\SuccessLoginResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_action_successful(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('allo123'),
            'email' => 'email.com'
        ]);

        $request = new LoginRequest([
            'password' => 'allo123',
            'email' => 'email.com'
        ]);
        $action = app(LoginActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(SuccessLoginResource::class, $userAction);
        $this->assertEquals($user->id, $userAction->resource->id);
    }

    public function test_action_password_failed(): void{
        $user = User::factory()->create([
            'password' => Hash::make(fake()->password),
            'email' => 'email.com'
        ]);
        $request = new LoginRequest([
            'password' => fake()->password,
            'email' => 'email.com'
        ]);
        $action = app(LoginActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(ErrorLoginResource::class, $userAction);
    }
    public function test_action_email_failed(): void{
        $user = User::factory()->create([
            'password' => Hash::make('allo123'),
            'email' => fake()->email
        ]);
        $request = new LoginRequest([
            'password' => 'allo123',
            'email' => fake()->email
        ]);
        $action = app(LoginActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(ErrorLoginResource::class, $userAction);
    }
}
