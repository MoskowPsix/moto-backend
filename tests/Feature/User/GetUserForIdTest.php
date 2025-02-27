<?php

namespace Tests\Feature\User;

use App\Contracts\Actions\Controllers\User\GetUserForIdActionContract;
use App\Contracts\Actions\Controllers\User\UpdateUserActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\User\GetForId\SuccessUserGetForIdResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetUserForIdTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    public function test_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $action = app(GetUserForIdActionContract::class);

        $response = $action($user->id);
        $this->assertInstanceOf(SuccessUserGetForIdResource::class, $response);
    }

    public function test_not_found(): void
    {
        $user = User::factory()->create();
        $action = app(GetUserForIdActionContract::class);

        $response = $action(fake()->biasedNumberBetween(100, 200));
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
}
