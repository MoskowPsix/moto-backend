<?php

namespace Tests\Feature\Cup;

use App\Actions\Controllers\Cup\GetForIdCupAction;
use App\Contracts\Actions\Controllers\Cup\GetForIdCupActionContract;
use App\Http\Requests\Cup\GetForIdCupRequest;
use App\Http\Resources\Cup\GetForId\SuccessGetForIdCupResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Cup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetForIdCupActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success_with_no_request(): void
    {
        $cup = Cup::factory()->create();
        $request = new GetForIdCupRequest();

        $action = app(GetForIdCupActionContract::class);
        $response = $action($cup->id, $request);

        $this->assertInstanceOf(SuccessGetForIdCupResource::class, $response);
    }

    public function test_action_success(): void
    {
        $cup = Cup::factory()->create();
        $request = new GetForIdCupRequest([$cup]);

        $action = app(GetForIdCupActionContract::class);
        $response = $action($cup->id, $request);

        $this->assertInstanceOf(SuccessGetForIdCupResource::class, $response);
    }

    public function test_action_not_found_resource(): void
    {
        $cup = Cup::factory()->create();
        $request = new GetForIdCupRequest([$cup]);

        $action = app(GetForIdCupActionContract::class);
        $response = $action(-1, $request);

        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
}
