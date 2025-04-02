<?php

namespace Tests\Feature\Command;

use App\Contracts\Actions\Controllers\Command\GetCoachesForAllUsersActionContract;
use App\Http\Requests\Command\GetCoachesForAllUsersRequest;
use App\Http\Resources\Command\GetCoachesForAll\SuccessGetCoachesForAllCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCoachesForAllUsersActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $command = Command::factory()->create();
        $request = new GetCoachesForAllUsersRequest([
            'paginate'  => 1,
            'page'      => 1,
            'limit'     => 10,
        ]);
        $action = app(GetCoachesForAllUsersActionContract::class);
        $response = $action($command->id, $request);
        $this->assertInstanceOf(SuccessGetCoachesForAllCommandResource::class, $response);
    }
    public function test_action_not_found(): void
    {
        $command = Command::factory()->create();
        $request = new GetCoachesForAllUsersRequest([
            'paginate'  => 1,
            'page'      => 1,
            'limit'     => 10,
        ]);
        $action = app(GetCoachesForAllUsersActionContract::class);
        $response = $action(-1, $request);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
}
