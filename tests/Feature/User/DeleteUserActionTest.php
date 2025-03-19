<?php

namespace Tests\Feature\User;

use App\Contracts\Actions\Controllers\User\DeleteUserActionContract;
use App\Http\Resources\User\Delete\SuccessUserDeleteResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteUserActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $action = app(DeleteUserActionContract::class);
        $response = $action($user);

        $this->assertInstanceOf(SuccessUserDeleteResource::class, $response);
    }
}
