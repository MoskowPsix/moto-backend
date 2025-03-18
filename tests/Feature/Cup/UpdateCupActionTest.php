<?php

namespace Tests\Feature\Cup;

use App\Contracts\Actions\Controllers\Cup\UpdateCupActionContract;
use App\Http\Requests\Cup\UpdateCupRequest;
use App\Http\Resources\Cup\Update\SuccessUpdateCupResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Cup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateCupActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_user_permission(): void
    {
        $userFirst = User::factory()->create();
        $userSecond = User::factory()->create();

        $cupResource = Cup::factory()->create([
            'user_id' => $userSecond->id,
        ]);
        $cup = [
            'userId'        => $userSecond->id,
            'locationId'    => $cupResource->location_id,
            'name'          => $cupResource->name,
            'year'          => $cupResource->year,
            'stages'        => $cupResource->stages,
        ];
        Sanctum::actingAs($userFirst);

        $resource = new UpdateCupRequest($cup);

        $action = app(UpdateCupActionContract::class);
        $response = $action($cupResource->id, $resource);

        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }

    public function test_action_not_found_resource(): void
    {
        $user = User::factory()->create();
        $cupResource = Cup::factory()->create([
            'user_id' => $user->id,
        ]);
        $cup = [
            'userId'        => $cupResource->user_id,
            'locationId'    => $cupResource->location_id,
            'name'          => $cupResource->name,
            'year'          => $cupResource->year,
            'stages'        => $cupResource->stages,
        ];
        Sanctum::actingAs($user);

        $resource = new UpdateCupRequest($cup);

        $action = app(UpdateCupActionContract::class);
        $response = $action(-1, $resource);

        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $cupResource = Cup::factory()->create([
            'user_id' => $user->id,
        ]);
        $cup = [
            'userId'        => $cupResource->user_id,
            'locationId'    => $cupResource->location_id,
            'name'          => $cupResource->name,
            'year'          => $cupResource->year,
            'stages'        => $cupResource->stages,
        ];
        Sanctum::actingAs($user);

        $resource = new UpdateCupRequest($cup);

        $action = app(UpdateCupActionContract::class);
        $response = $action($cupResource->id, $resource);

        $this->assertInstanceOf(SuccessUpdateCupResource::class, $response);
    }
}
