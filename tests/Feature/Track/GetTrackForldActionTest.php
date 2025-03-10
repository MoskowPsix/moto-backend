<?php

namespace Tests\Feature\Track;

use App\Contracts\Actions\Controllers\Track\GetTrackForIdActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Track\GetTrackForId\SuccessGetTrackForIdResource;
use App\Models\Track;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetTrackForldActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_get_for_id_success(): void
    {
        $track = Track::factory()->create();

        $action = app(GetTrackForIdActionContract::class);
        $response = $action($track->id);

        $this->assertInstanceOf(SuccessGetTrackForIdResource::class, $response);
    }
    public function test_get_for_id_not_found(): void
    {
        $track = Track::factory()->create();

        $action = app(GetTrackForIdActionContract::class);
        $response = $action(fake()->biasedNumberBetween(100, 200));
        $this->assertInstanceOf(NotFoundResource::class, $response);

    }
}
