<?php

namespace Tests\Feature\Command;

use App\Contracts\Actions\Controllers\Command\GetCouchesActionContract;
use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetCommand\SuccessGetCommandResource;
use App\Http\Resources\Command\GetCouches\SuccessGetCouchesCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCouchesActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_found(): void
    {
        $request = new GetCouchesCommandRequest();
        $action = app(GetCouchesActionContract::class);
        $response = $action(-1, $request);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

//    public function test_action_success(): void
//    {
//        $commandSeed = Command::factory()->make();
//        $command = Command::factory()->create([
//            'coach' => $commandSeed->coach,
//        ]);
//        $request = new GetCouchesCommandRequest($command);
//        $action = app(GetCouchesActionContract::class);
//        $response = $action($command->id, $request);
//        $this->assertInstanceOf(SuccessGetCouchesCommandResource::class, $response);
//    }
}
