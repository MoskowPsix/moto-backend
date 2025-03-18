<?php

namespace Tests\Feature\Cup;

use App\Contracts\Actions\Controllers\Cup\GetForRaceIdCupActionContract;
use App\Http\Requests\Cup\GetForRaceIdCupRequest;
use App\Http\Resources\Cup\GetForRaceId\SuccessGetForRaceIdCupResource;
use App\Models\Cup;
use App\Models\Race;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetForRaceIdCupActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $race = Race::factory()->create();
        $cup = Cup::factory()->create();

        $request = new GetForRaceIdCupRequest([
            'race_id' => $race->id,
        ]);
        $action = app(GetForRaceIdCupActionContract::class);
        $response = $action($cup->id, $request);
        $this->assertInstanceOf(SuccessGetForRaceIdCupResource::class, $response);
    }
}
