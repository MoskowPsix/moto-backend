<?php

namespace Tests\Feature\Command;

use App\Actions\Controllers\Command\CreateCommandAction;
use App\Http\Requests\Command\CreateCommandRequest;
use App\Http\Resources\Command\Create\SuccessCreateCommandResource;
use App\Models\Command;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateCommandActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();

        $commandSeed = Command::factory()->make();
        $command = [
            'name' => $commandSeed->name,
            'city' => $commandSeed->city,
            'user_id' => $user->id,
            'location_id' => $commandSeed->location_id,
        ];
        Sanctum::actingAs($user);
        $request = new CreateCommandRequest($command);

        $action = app(CreateCommandAction::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessCreateCommandResource::class, $response);
    }

    public function test_action_success_with_avatar(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $commandSeed = Command::factory()->make();
        $image = UploadedFile::fake()->create('avatar.png');
        $command = [
            'name' => $commandSeed->name,
            'city' => $commandSeed->city,
            'avatar'  => $image,
            'user_id' => $user->id,
            'location_id' => $commandSeed->location_id,
        ];

        Sanctum::actingAs($user);
        $request = new CreateCommandRequest($command);

        $action = app(CreateCommandAction::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessCreateCommandResource::class, $response);
    }
}
