<?php

namespace Tests\Feature\Command;

use App\Actions\Controllers\Command\UpdateCommandAction;
use App\Http\Requests\Command\UpdateCommandRequest;
use App\Http\Resources\Command\Update\SuccessUpdateCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateCommandActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();

        $commandSeed = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $avatar = UploadedFile::fake()->create('file.png');
        $command = [
            'name' => $commandSeed->name,
            'city' => $commandSeed->city,
            'avatar' => $avatar,
            'user_id' => $user->id,
            'location_id' => $commandSeed->location_id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateCommandRequest($command);

        $action = app(UpdateCommandAction::class);
        $response = $action($commandSeed->id, $request);

        $this->assertInstanceOf(SuccessUpdateCommandResource::class, $response);
    }
    public function test_action_success_avatar(): void
    {
        $user = User::factory()->create();

        $commandSeed = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $avatar = UploadedFile::fake()->create('file.png');
        $secondAvatar = UploadedFile::fake()->create('secondFile.jpg');
        $command = [
            'name' => $commandSeed->name,
            'city' => $commandSeed->city,
            'avatar' => $avatar,
            'avatar' => $commandSeed->$secondAvatar,
            'user_id' => $user->id,
            'location_id' => $commandSeed->location_id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateCommandRequest($command);

        $action = app(UpdateCommandAction::class);
        $response = $action($commandSeed->id, $request);

        $this->assertInstanceOf(SuccessUpdateCommandResource::class, $response);
    }

    public function test_action_not_permission(): void
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();

        $commandSeed = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $command = [
            'name' => $commandSeed->name,
            'city' => $commandSeed->city,
            'user_id' => $user->id,
            'location_id' => $commandSeed->location_id,
        ];
        Sanctum::actingAs($secondUser);
        $request = new UpdateCommandRequest($command);

        $action = app(UpdateCommandAction::class);
        $response = $action($commandSeed->id, $request);

        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }

    public function test_action_not_found(): void
    {
        $user = User::factory()->create();

        $commandSeed = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $command = [
            'name' => $commandSeed->name,
            'city' => $commandSeed->city,
            'user_id' => $user->id,
            'location_id' => $commandSeed->location_id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateCommandRequest($command);

        $action = app(UpdateCommandAction::class);
        $response = $action(-1, $request);

        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
}
