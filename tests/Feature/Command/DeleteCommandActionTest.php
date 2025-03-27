<?php

namespace Tests\Feature\Command;

use App\Contracts\Actions\Controllers\Command\DeleteCommandActionContract;
use App\Http\Resources\Command\Delete\SuccessDeleteCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteCommandActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(DeleteCommandActionContract::class);
        $response = $action($command->id);
        $this->assertInstanceOf(SuccessDeleteCommandResource::class, $response);
    }
    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $action = app(DeleteCommandActionContract::class);
        $response = $action(-1);
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
        $action = app(DeleteCommandActionContract::class);
        $response = $action($command->id);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
}
