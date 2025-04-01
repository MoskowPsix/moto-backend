<?php

namespace Tests\Feature\Document;

use App\Contracts\Actions\Controllers\Document\GetDocumentForUserActionContract;
use App\Http\Requests\Document\GetDocumentForUserRequest;
use App\Http\Resources\Document\GetForUser\SuccessGetDocumentForUserResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetDocumentForUserActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $request = new GetDocumentForUserRequest();
        $action = app(GetDocumentForUserActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessGetDocumentForUserResource::class, $response);
    }
    public function test_action_success_command(): void
    {
        $command = Command::factory()->create();
        $member = User::factory()->create();
        $command->members()->attach($member->id);

        Document::factory()->create(['user_id' => $member->id]);

        $request = new GetDocumentForUserRequest([
            'userId' => $member->id,
            'commandId' => $command->id
        ]);

        $response = app(GetDocumentForUserActionContract::class)($request);

        $this->assertInstanceOf(SuccessGetDocumentForUserResource::class, $response);
    }
    public function test_action_not_user_not_in_command(): void
    {
        $command = Command::factory()->create();
        $member = User::factory()->create();

        $request = new GetDocumentForUserRequest([
            'userId' => $member->id,
            'commandId' => $command->id
        ]);

        $action = app(GetDocumentForUserActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
    public function test_action_not_command(): void
    {
        $command = Command::factory()->create();
        $member = User::factory()->create();

        $request = new GetDocumentForUserRequest([
            'userId' => $member->id,
            'commandId' => -1
        ]);

        $action = app(GetDocumentForUserActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
}
