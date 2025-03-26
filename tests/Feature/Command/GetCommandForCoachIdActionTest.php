<?php

namespace Tests\Feature\Command;

use App\Contracts\Actions\Controllers\Command\GetCommandForCoachIdActionContract;
use App\Http\Requests\Command\GetForCoachIdCommandRequest;
use App\Http\Resources\Command\GetCommandForCoach\SuccessGetCommandForCoachIdResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetCommandForCoachIdActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $request = new GetForCoachIdCommandRequest();
        $action = app(GetCommandForCoachIdActionContract::class);
        $response = $action($request);
        $this->assertInstanceOf(SuccessGetCommandForCoachIdResource::class, $response);
    }
}
