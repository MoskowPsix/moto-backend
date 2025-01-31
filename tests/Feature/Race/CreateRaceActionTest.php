<?php

namespace Race;

use App\Contracts\Actions\Race\CreateRaceActionContract;
use App\Http\Requests\Race\CreateRaceRequest;
use App\Http\Resources\Race\Create\SuccessCreateRaceResource;
use App\Models\Level;
use App\Models\Race;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateRaceActionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $track = Track::factory()->create();

        $file = UploadedFile::fake()->create('file.png');
        $race_seed = Race::factory()->make();
        $race = [
            'name' => $race_seed->name,
            'desc' => $race_seed->desc,
            'dateStart' => $race_seed->date_start,
            'images' => [$file],
            'trackId' => $track->id,
        ];

        $raceRequest = new CreateRaceRequest($race);
        Sanctum::actingAs($user);

        $action = app(CreateRaceActionContract::class);
        $response = $action($raceRequest);

        $this->assertInstanceOf(SuccessCreateRaceResource::class, $response);
    }
}
