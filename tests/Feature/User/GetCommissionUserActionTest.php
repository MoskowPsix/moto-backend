<?php

namespace Tests\Feature\User;

use App\Actions\Controllers\User\GetCommisionUserAction;
use App\Contracts\Actions\Controllers\User\GetCommisionUserActionContract;
use App\Http\Requests\User\GetCommisionUserRequest;
use App\Http\Resources\User\GetCommision\SuccessGetCommisionUserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetCommissionUserActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $request = new GetCommisionUserRequest([
            'paginate'  => 1,
        ]);
        $action = app(GetCommisionUserActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessGetCommisionUserResource::class, $response);
    }
}
