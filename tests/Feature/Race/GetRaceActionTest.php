<?php

namespace Tests\Feature\Race;

use App\Contracts\Actions\Race\GetRaceActionContract;
use App\Contracts\Actions\Track\GetTracksActionContract;
use App\Http\Requests\Race\GetRaceRequest;
use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Race\GetRaces\SuccessGetRaceResource;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;
use App\Models\Race;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetRaceActionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_action_success_request_null(): void
    {
        $getRace = new GetRaceRequest();

        $action = app(GetRaceActionContract::class);
        $response = $action($getRace);

        $this->assertInstanceOf(SuccessGetRaceResource::class, $response);
    }

    public function test_action_success_request(): void
    {
        $race = Race::factory()->create();
        $getRace = new GetRaceRequest([
            'userId'            => $race->user->id,
            'paginate'          => 0,
            'page'              => 1,
            'limit'             => 10,
            'appointmentUser'   => 1,
            'trackId'           => $race->track->id,
            'pastRace'          => 1,
        ]);

        $action = app(GetRaceActionContract::class);
        $response = $action($getRace);

        $this->assertInstanceOf(SuccessGetRaceResource::class, $response);
    }
}
