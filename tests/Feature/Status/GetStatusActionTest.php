<?php

namespace Tests\Feature\Status;

use App\Contracts\Actions\Controllers\Status\GetStatusesActionContract;
use App\Http\Resources\Status\GetStatuses\SuccessGetStatusesResource;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetStatusActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    public function test_action_success(): void
    {
        $status = Status::factory()->create();
        $action = app(GetStatusesActionContract::class);
        $response = $action($status);
        $this->assertInstanceOf(SuccessGetStatusesResource::class, $response);
    }
}
