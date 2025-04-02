<?php

namespace Tests\Feature\Role;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Role\ChangeRoleForDefaultUserActionContract;
use App\Http\Requests\Role\ChangeRoleForDefaultUserRequest;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\NoRoleChangeRoleForDefaultUserResource;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChangeRoleForDefaultUserActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success_with_rider(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $riderRole = Role::where('name', RoleConstant::RIDER)->firstOrFail();

        $requestData = [
            'roleId' => $riderRole->id,
        ];

        $request = new ChangeRoleForDefaultUserRequest($requestData);
        $action = app(ChangeRoleForDefaultUserActionContract::class);
        $response = $action($request);
        $this->assertInstanceOf(SuccessChangeRoleForDefaultUserResource::class, $response);
    }
    public function test_action_success_with_auth_phone(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $phone = Phone::factory()->verified()->create([
            'user_id' => $user->id,
        ]);

        $riderRole = Role::where('name', RoleConstant::COUCH)->firstOrFail();

        $requestData = [
            'roleId' => $riderRole->id,
        ];

        $request = new ChangeRoleForDefaultUserRequest($requestData);
        $action = app(ChangeRoleForDefaultUserActionContract::class);
        $response = $action($request);
        $this->assertInstanceOf(SuccessChangeRoleForDefaultUserResource::class, $response);
    }
    public function test_action_no_role(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $phone = Phone::factory()->verified()->create([
            'user_id' => $user->id,
        ]);

        $role = Role::where('name', RoleConstant::ROOT)->firstOrFail();

        $requestData = [
            'roleId' => $role->id,
        ];

        $request = new ChangeRoleForDefaultUserRequest($requestData);
        $action = app(ChangeRoleForDefaultUserActionContract::class);
        $response = $action($request);
        $this->assertInstanceOf(NoRoleChangeRoleForDefaultUserResource::class, $response);
    }
}
