<?php

namespace Tests\Feature\Command;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Command\AddCouchActionContract;
use App\Http\Resources\Command\AddCouch\SuccessAddCouchCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AddCouchActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_found_command(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $command = Command::factory()->create();

        $action = app(AddCouchActionContract::class);
        $response = $action(-1, $user->id);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
    public function test_action_not_found_user(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $couch = User::factory()->create();
        $couch->assignRole(RoleConstant::COUCH);

        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);

        $action = app(AddCouchActionContract::class);
        $response = $action($command->id, -1);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
    public function test_action_not_permission(): void
    {
        $user = User::factory()->create();
        $userSecond = User::factory()->create();
        Sanctum::actingAs($userSecond);

        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);

        $action = app(AddCouchActionContract::class);
        $response = $action($command->id, $user->id);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
    public function test_action_not_permission_role(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);

        $action = app(AddCouchActionContract::class);
        $response = $action($command->id, $user->id);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $couch = User::factory()->create();
        $couch->assignRole(RoleConstant::COUCH);
        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(AddCouchActionContract::class);
        $response = $action($command->id, $couch->id);
        $this->assertInstanceOf(SuccessAddCouchCommandResource::class, $response);
    }
}
