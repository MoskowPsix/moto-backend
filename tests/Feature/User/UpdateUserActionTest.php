<?php

namespace Tests\Feature\User;

use App\Contracts\Actions\Race\GetForIdRaceActionContract;
use App\Contracts\Actions\User\UpdateUserActionContract;
use App\Http\Requests\Race\GetForIdRaceRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Race\GetRaceForId\SuccessGetRaceForIdResource;
use App\Http\Resources\User\Update\ErrorUpdateUserResource;
use App\Http\Resources\User\Update\SuccessUpdateUserResource;
use App\Models\Race;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rule;
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
