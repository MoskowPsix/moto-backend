<?php

namespace Tests\Feature\Race;

use App\Contracts\Actions\Controllers\Race\ToggleIsWorkRaceActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\ToggleIsWork\SuccessToogleIsWorkRaceResource;
use App\Models\Race;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ToggleIsWorkRaceActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $race_seed = Race::factory()->create([
            'user_id' => $user->id,
        ]);

        $race = [
            'is_work' => $race_seed->is_work,
        ];
        Sanctum::actingAs($user);

        $action = app(ToggleIsWorkRaceActionContract::class);
        $response = $action($race_seed->id);
        $this->assertInstanceOf(SuccessToogleIsWorkRaceResource::class, $response);
    }
    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        $race_seed = Race::factory()->create([
            'user_id' => $user->id,
        ]);

        $race = [
            'is_work' => $race_seed->is_work,
        ];
        Sanctum::actingAs($user);

        $action = app(ToggleIsWorkRaceActionContract::class);
        $response = $action(-1);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

    public function test_action_not_user_permission(): void
    {
        $user = User::factory()->create();
        $userSecond = User::factory()->create();

        $race_seed = Race::factory()->create([
            'user_id' => $user->id,
        ]);

        $race = [
            'is_work' => $race_seed->is_work,
        ];
        Sanctum::actingAs($userSecond);

        $action = app(ToggleIsWorkRaceActionContract::class);
        $response = $action($race_seed->id);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
}
