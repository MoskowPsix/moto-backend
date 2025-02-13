<?php

namespace Auth;

use App\Contracts\Actions\Controllers\Auth\RegisterActionContract;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\Register\ErrorRegisterResource;
use App\Http\Resources\Auth\Register\SuccessRegisterResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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
    public function test_action_successful_with_image(): void
    {
        $image = UploadedFile::fake()->create('file.png');
        $user_seed = User::factory()->make();
        $user = [
            'name' => $user_seed->name,
            'email' => $user_seed->email,
            'password' => $user_seed->password,
            'avatar' => $user_seed->$image,
        ];

        $request = new RegisterRequest($user);

        $action = app(RegisterActionContract::class);
        $userAction = $action($request);

        $this->assertInstanceOf(SuccessRegisterResource::class, $userAction);
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
