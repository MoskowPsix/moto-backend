<?php

namespace Tests\Feature\Track;

use App\Contracts\Actions\Track\GetTrackForIdActionContract;
use App\Http\Resources\Track\GetTrackForId\SuccessGetTrackForIdResource;
use App\Models\Track;
use Tests\TestCase;

class GetTrackForldActionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $track = Track::factory()->create();

        $request = app(GetTrackForIdActionContract::class);
        $response = $request($track->id);

        $this->assertInstanceOf(SuccessGetTrackForIdResource::class, $response);

    }
}
