<?php

namespace Tests\Feature\Race;

use App\Contracts\Actions\Controllers\Race\DeleteRaceActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\Delete\SuccessDeleteRaceResource;
use App\Models\Race;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteRaceActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $race = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(DeleteRaceActionContract::class);
        $response = $action($race->id);
        $this->assertInstanceOf(SuccessDeleteRaceResource::class, $response);
    }

    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $race = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(DeleteRaceActionContract::class);
        $response = $action(-1);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
    public function test_action_not_permission(): void
    {
        $user = User::factory()->create();
        $userSecond = User::factory()->create();

        Sanctum::actingAs($userSecond);

        $race = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(DeleteRaceActionContract::class);
        $response = $action($race->id);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
}
