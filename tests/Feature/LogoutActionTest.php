<?php

namespace Tests\Feature;

use App\Actions\Auth\LogoutAction;
use App\Contracts\Actions\Auth\LogoutActionContract;
use App\Http\Resources\Auth\Logout\ErrorLogoutResource;
use App\Http\Resources\Auth\Logout\SuccessLogoutResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_action_error(): void
    {
        $logoutAction = app(LogoutActionContract::class);
        $response = $logoutAction();
        $this->assertEquals(ErrorLogoutResource::make([]), $response);
    }
}
