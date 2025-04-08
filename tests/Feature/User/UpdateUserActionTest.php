<?php

namespace Tests\Feature\User;

use App\Contracts\Actions\Controllers\User\UpdateUserActionContract;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Auth\Logout\SuccessLogoutResource;
use App\Http\Resources\User\Update\ErrorUpdateUserResource;
use App\Http\Resources\User\Update\SuccessUpdateUserResource;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateUserActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    public function test_update_user_success(): void
    {
        $user = User::factory()->create([
            'avatar' => 'sssssss',

        ]);
        $image = UploadedFile::fake()->create('file.png');

        Sanctum::actingAs($user);
        $req = [
            'name'      => 'test',
            'email'     => 'test@test',
            'avatar'    => $image,
            'number'    => fake()->phoneNumber,
        ];
        $userRequest = new UpdateUserRequest($req);

        $action = app(UpdateUserActionContract::class);
        $response = $action($userRequest);
        $this->assertInstanceOf(SuccessUpdateUserResource::class, $response);
    }
    public function test_update_user_success_with_phone(): void
    {
        $user = User::factory()->create([
            'avatar' => 'sssssss',
        ]);
        $phone = Phone::factory()->create([
            'user_id' => $user->id,
        ]);
        $image = UploadedFile::fake()->create('file.png');

        Sanctum::actingAs($user);
        $req = [
            'name'      => 'test',
            'email'     => 'test@test',
            'avatar'    => $image,
            'number'    => fake()->phoneNumber,
        ];
        $userRequest = new UpdateUserRequest($req);

        $action = app(UpdateUserActionContract::class);
        $response = $action($userRequest);
        $this->assertInstanceOf(SuccessUpdateUserResource::class, $response);
    }

    public function test_update_user_error(): void
    {
        $image = UploadedFile::fake()->create('file.png');

        $req = [
            'name'      => 'test',
            'email'     => 'test@test',
            'avatar'    => $image,
        ];
        $userRequest = new UpdateUserRequest($req);

        $action = app(UpdateUserActionContract::class);
        $response = $action($userRequest);
        $this->assertInstanceOf(ErrorUpdateUserResource::class, $response);
    }
}
