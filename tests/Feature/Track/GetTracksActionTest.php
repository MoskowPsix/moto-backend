<?php

namespace Tests\Feature\Track;

use App\Contracts\Actions\Track\GetTracksActionContract;
use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;
use Tests\TestCase;

class GetTracksActionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $getTrack = new GetTracksRequest();

        $action = app(GetTracksActionContract::class);
        $response = $action($getTrack);

        $this->assertInstanceOf(SuccessGetTracksResource::class, $response);
    }
}
