<?php

namespace Tests\Feature\User;

use App\Actions\Controllers\User\GetUserForTokenAction;
use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetUserForTokenTest extends TestCase
{

    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $action = app(GetUserForTokenAction::class);
        $response = $action($user);
        $this->assertInstanceOf(SuccessGetUserForTokenResource::class, $response);
    }
}
