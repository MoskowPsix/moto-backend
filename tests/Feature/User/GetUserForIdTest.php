<?php

namespace Tests\Feature\User;

use App\Contracts\Actions\Controllers\User\GetUserForIdActionContract;
use App\Contracts\Actions\Controllers\User\UpdateUserActionContract;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetUserForIdTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_success(): void
    {
        $user = User::factory()->create(['avatar' => 'sssssss']);
        Sanctum::actingAs($user);
        $action = app(GetUserForIdActionContract::class);

        $response->assertStatus(200);
    }
}
