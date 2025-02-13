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

    public function test_action_success_with_id_and_appointments(): void
    {
        $race = Race::factory()->create();
        $user = User::factory()->create();

        $this->mock(Request::class, function ($mock) use ($user) {
            $mock->shouldReceive('has')->with('userId')->andReturn(true); // Параметр userId существует
            $mock->shouldReceive('has')->with('appointmentUser')->andReturn(true); // Параметр appointmentUser существует
            $mock->shouldReceive('get')->with('userId')->andReturn($user->id); // Возвращаем ID пользователя
        });

        $raceRequest = new GetForIdRaceRequest([
            'userId'            => 1,
            'appointmentUser'   => 1,
        ]);
        $race->appointments()->attach($user->id);

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
}
