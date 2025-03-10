<?php

namespace Tests\Feature\Track;

use App\Contracts\Actions\Controllers\Track\GetTracksActionContract;
use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetTracksActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
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
        $getTrack = new GetTracksRequest(
            [
                'userId'    => 1,
                'paginate'  => 1,
                'page'      => 1,
                'limit'     => 10,
            ]);

        $action = app(GetTracksActionContract::class);
        $response = $action($getTrack);

        $this->assertInstanceOf(SuccessGetTracksResource::class, $response);
    }
}
