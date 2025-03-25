<?php

namespace Tests\Feature\Track;

use App\Contracts\Actions\Controllers\Track\DeleteTrackActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Track\Delete\SuccessDeleteTrackResource;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteTrackActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $track = Track::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(DeleteTrackActionContract::class);
        $response = $action($track->id);
        $this->assertInstanceOf(SuccessDeleteTrackResource::class, $response);
    }

    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $track = Track::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(DeleteTrackActionContract::class);
        $response = $action(-1);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
    public function test_action_not_user_permission(): void
    {
        $user = User::factory()->create();
        $userSecond = User::factory()->create();
        Sanctum::actingAs($userSecond);
        $track = Track::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(DeleteTrackActionContract::class);
        $response = $action($track->id);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
}
