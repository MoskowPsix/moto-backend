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
use Tests\TestCase;

class GetForIdRaceActionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_action_success_request_null(): void
    {
        $race = Race::factory()->create();

        $raceRequest = new GetForIdRaceRequest();

        $action = app(GetForIdRaceActionContract::class);
        $response = $action($race->id, $raceRequest);
        $this->assertInstanceOf(SuccessGetRaceForIdResource::class, $response);
    }

    public function test_action_success(): void
    {
        $race = Race::factory()->create();

        $raceRequest = new GetForIdRaceRequest([
            'userId'            => 1,
            'appointmentUser'   => 1,
        ]);

        $action = app(GetForIdRaceActionContract::class);
        $response = $action($race->id, $raceRequest);
        $this->assertInstanceOf(SuccessGetRaceForIdResource::class, $response);
    }

    public function test_action_success_with_id_and_appointment_user(): void
    {
        $user = User::factory()->create();
        $race = Race::factory()->create();

        $raceRequest = new GetForIdRaceRequest([
            'userId'            => $user->id,
            'appointmentUser'   => 1,
        ]);

        $action = app(GetForIdRaceActionContract::class);
        $response = $action($race->id, $raceRequest);

        $this->assertInstanceOf(SuccessGetRaceForIdResource::class, $response);

        $resource = $response->resource;
        $this->assertNotNull($resource->appointments_exists);
    }
}
