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
    protected bool $seed = true;

    public function test_action_success_request_null(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $raceSeed = Race::factory()->create();
        $race = [
            'userId' => $user->id,
        ];

        $raceRequest = new GetForIdRaceRequest($race);

        $action = app(GetForIdRaceActionContract::class);
        $response = $action($raceSeed->id, $raceRequest);
        $this->assertInstanceOf(SuccessGetRaceForIdResource::class, $response);
    }
    public function test_get_race_with_appointment_check(): void
    {
        $user = User::factory()->create();
        $race = Race::factory()->create();

        $request = new GetForIdRaceRequest([
            'userId' => $user->id,
            'appointmentUser' => true,
        ]);

        $action = app(GetForIdRaceActionContract::class);
        $response = $action($race->id, $request);

        $responseData = $response->toArray(request());
        $this->assertInstanceOf(SuccessGetRaceForIdResource::class, $response);
    }
    public function test_get_race_with_favourites_check(): void
    {
        $user = User::factory()->create();
        $race = Race::factory()->create();

        $request = new GetForIdRaceRequest([
            'userId' => $user->id,
            'favouritesUser' => true,
        ]);

        $action = app(GetForIdRaceActionContract::class);
        $response = $action($race->id, $request);

        $responseData = $response->toArray(request());
        $this->assertInstanceOf(SuccessGetRaceForIdResource::class, $response);
    }
    public function test_get_race_with_commission_check(): void
    {
        $user = User::factory()->create();
        $race = Race::factory()->create();

        $request = new GetForIdRaceRequest([
            'userIdExists' => $user->id,
            'commissionUser' => true,
        ]);

        $action = app(GetForIdRaceActionContract::class);
        $response = $action($race->id, $request);

        $responseData = $response->toArray(request());
        $this->assertInstanceOf(SuccessGetRaceForIdResource::class, $response);
    }
    public function test_get_race_with_all_checks(): void
    {
        $user = User::factory()->create();
        $race = Race::factory()->create();

        $request = new GetForIdRaceRequest([
            'userId' => $user->id,
            'appointmentUser' => true,
            'favouritesUser' => true,
            'userIdExists' => $user->id,
            'commissionUser' => true,
        ]);

        $action = app(GetForIdRaceActionContract::class);
        $response = $action($race->id, $request);

        $responseData = $response->toArray(request());
        $this->assertInstanceOf(SuccessGetRaceForIdResource::class, $response);
    }
}
