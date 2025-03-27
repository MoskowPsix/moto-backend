<?php

namespace Tests\Feature\Role;

use App\Contracts\Actions\Controllers\Role\AddCommissionUserActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddCommissionUserActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        $action = app(AddCommissionUserActionContract::class);
        $response = $action(-1);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $action = app(AddCommissionUserActionContract::class);
        $response = $action($user->id);
        $this->assertInstanceOf(SuccessChangeRoleForDefaultUserResource::class, $response);
    }
}
