<?php

namespace Tests\Feature\Race;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Race\AddCommissionActionContract;
use App\Http\Requests\Race\AddCommissionRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\User\AddCommission\SuccessAddCommissionResource;
use App\Http\Resources\User\AddCommission\UserIncorectRoleAddCommissionResource;
use App\Models\Race;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AddCommissionActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_found(): void
    {
        $race = Race::factory()->create();
        $request = new AddCommissionRequest();
        $action = app(AddCommissionActionContract::class);
        $response = $action(-1, $request);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
    public function test_action_not_permission(): void
    {
        $user = User::factory()->create();
        $user_fake = User::factory()->create();
        Sanctum::actingAs($user_fake);

        $race = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $request = new AddCommissionRequest();
        $action = app(AddCommissionActionContract::class);
        $response = $action($race->id, $request);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
    public function test_action_incorrect_role(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $race = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $commission = User::factory()->create();
        $commission->assignRole(RoleConstant::RIDER);

        $request = new AddCommissionRequest([
            'usersIds' => [$commission->id],
        ]);

        $action = app(AddCommissionActionContract::class);
        $response = $action($race->id, $request);
        $this->assertInstanceOf(UserIncorectRoleAddCommissionResource::class, $response);
    }
    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $race = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $commission = User::factory()->create();
        $commission->assignRole(RoleConstant::COMMISSION);

        $request = new AddCommissionRequest([
            'usersIds' => [$commission->id],
        ]);

        $action = app(AddCommissionActionContract::class);
        $response = $action($race->id, $request);
        $this->assertInstanceOf(SuccessAddCommissionResource::class, $response);
    }
}
