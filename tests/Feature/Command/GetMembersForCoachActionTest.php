<?php

namespace Tests\Feature\Command;

use App\Contracts\Actions\Controllers\Command\GetMembersForCoachActionContract;
use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetMembersForCoach\GetMembersForCoachCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use App\Models\Document;
use App\Models\Location;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetMembersForCoachActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_user_permission(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $request = new GetCouchesCommandRequest([
            'paginate'  => 1,
            'page'      => 1,
            'limit'     => 10,
        ]);

        $action = app(GetMembersForCoachActionContract::class);
        $response = $action($command->id, $request);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
    public function test_action_success(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $command->coaches()->attach($user->id);

        $request = new GetCouchesCommandRequest([
            'paginate'  => 1,
            'page'      => 1,
            'limit'     => 10,
        ]);

        $action = app(GetMembersForCoachActionContract::class);
        $response = $action($command->id, $request);
        $this->assertInstanceOf(GetMembersForCoachCommandResource::class, $response);
    }
}
