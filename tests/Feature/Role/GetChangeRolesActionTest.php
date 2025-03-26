<?php

namespace Tests\Feature\Role;

use App\Contracts\Actions\Controllers\Role\GetChangeRolesActionContract;
use App\Http\Resources\Role\GetChangeRole\SuccessGetChangeRoleResource;
use Database\Factories\RoleFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetChangeRolesActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_test(): void
    {
        $action = app(GetChangeRolesActionContract::class);
        $response = $action();
        $this->assertInstanceOf(SuccessGetChangeRoleResource::class, $response);
    }
}
