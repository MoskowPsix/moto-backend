<?php

namespace Tests\Feature\User;

use App\Contracts\Actions\Controllers\User\UpdateUserActionContract;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\User\Update\ErrorUpdateUserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();

        $userRequest = new UpdateUserRequest();

        $action = app(UpdateUserActionContract::class);
        $response = $action($userRequest);
        $this->assertInstanceOf(ErrorUpdateUserResource::class, $response);
    }
}
