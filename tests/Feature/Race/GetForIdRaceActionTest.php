<?php

namespace Race;

use App\Contracts\Actions\Controllers\Race\GetForIdRaceActionContract;
use App\Http\Requests\Race\GetForIdRaceRequest;
use App\Http\Resources\Race\GetRaceForId\SuccessGetRaceForIdResource;
use App\Models\Race;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetForIdRaceActionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_action_success_request_null(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $raceSeed = Race::factory()->create();
        $race = [
            'user_id' => $user->id,
        ];

        $raceRequest = new GetForIdRaceRequest($race);

        $action = app(GetForIdRaceActionContract::class);
        $response = $action($raceSeed->id, $raceRequest);
        $this->assertInstanceOf(SuccessGetRaceForIdResource::class, $response);
    }
}
