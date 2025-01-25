<?php

namespace Tests\Feature\Track;

use App\Contracts\Actions\Track\CreateTracksActionContract;
use App\Http\Requests\Track\CreateTrackRequest;
use App\Http\Resources\Track\Create\ErrorCreateResource;
use App\Http\Resources\Track\Create\SuccessCreateResource;
use App\Models\Track;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTracksActionTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * A basic feature test example.
     */
    public function test_action_success(): void
    {
        $tracks = [
            Track::factory()->create()
        ];

        $request = new CreateTrackRequest($tracks);

        $action = app(CreateTracksActionContract::class);
        $response = $action($request);


        $this->assertInstanceOf(ErrorCreateResource::class, $response);
    }
}
