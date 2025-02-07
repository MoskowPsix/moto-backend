<?php

namespace Tests\Feature\User;

use App\Contracts\Actions\Track\GetTrackForIdActionContract;
use App\Contracts\Actions\User\GetUserForIdActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\User\GetForId\SuccessUserGetForIdResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUserForIdActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_action_success(): void
    {
        $user = User::factory()->create();

        $action = app(GetUserForIdActionContract::class);
        $response = $action($user->id);
        $this->assertInstanceOf(SuccessUserGetForIdResource::class , $response);
    }

    public  function test_action_not_found(): void
    {
        $user = User::factory()->create();
        $action = app(GetUserForIdActionContract::class);
        $response = $action(fake()->biasedNumberBetween(100, 200));
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
}
