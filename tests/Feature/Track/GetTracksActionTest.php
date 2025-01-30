<?php

namespace Tests\Feature\Track;

use App\Contracts\Actions\Track\GetTracksActionContract;
use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetTracksActionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_get_tracks_success(): void
    {
        $getTrack = new GetTracksRequest();

        $action = app(GetTracksActionContract::class);
        $response = $action($getTrack);

        $this->assertInstanceOf(SuccessGetTracksResource::class, $response);
    }

    public function test_get_tracks_with_user_filter_success(): void
    {
        $getTrack = new GetTracksRequest(['userId' => 1]);

        $action = app(GetTracksActionContract::class);
        $response = $action($getTrack);

        $this->assertInstanceOf(SuccessGetTracksResource::class, $response);
    }
}
