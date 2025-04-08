<?php

namespace Tests\Feature\Command;

use App\Contracts\Actions\Controllers\Command\ToggleMemberActionContract;
use App\Http\Resources\Command\ToggleMember\SuccessToggleMemberCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ToggleMemberActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_found(): void
    {
        $command = Command::factory()->create();
        $action = app(ToggleMemberActionContract::class);
        $response = $action(-1);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(ToggleMemberActionContract::class);
        $response = $action($command->id);
        $this->assertInstanceOf(SuccessToggleMemberCommandResource::class, $response);
    }
}
