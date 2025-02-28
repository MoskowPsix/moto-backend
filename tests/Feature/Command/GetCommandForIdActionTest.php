<?php

namespace Tests\Feature\Command;

use App\Contracts\Actions\Controllers\Command\GetForIdCommandActionContract;
use App\Http\Requests\Command\GetForIdCommandRequest;
use App\Http\Resources\Command\GetCommandForId\SuccessGetCommandForIdResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCommandForIdActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $command = Command::factory()->create();
        $commandRequest = new GetForIdCommandRequest([
            'locationId' => $command->location_id,
        ]);
        $action = app(GetForIdCommandActionContract::class);
        $response = $action($command->id, $commandRequest);
        $this->assertInstanceOf(SuccessGetCommandForIdResource::class, $response);
    }

    public function test_action_not_found(): void
    {
        $commandRequest = new GetForIdCommandRequest();

        $action = app(GetForIdCommandActionContract::class);
        $response = $action(0, $commandRequest);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
}
