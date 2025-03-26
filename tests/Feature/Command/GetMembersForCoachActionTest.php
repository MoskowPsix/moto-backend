<?php

namespace Tests\Feature\Command;

use App\Contracts\Actions\Controllers\Command\GetMembersForCoachActionContract;
use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetMembersForCoach\GetMembersForCoachCommandResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetMembersForCoachActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();


        $command = Command::factory()->create([
            'user_id' => $user->id,
        ]);
        $request = new GetCouchesCommandRequest([
            'paginate'  => 1,
            'page'      => 1,
            'limit'     => 10,
        ]);
        Sanctum::actingAs($user);
        $action = app(GetMembersForCoachActionContract::class);
        $response = $action($command->id, $request);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
}
