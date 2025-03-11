<?php

namespace Tests\Feature\Store;

use App\Contracts\Actions\Controllers\Store\CreateStoreActionContract;
use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Resources\Store\Create\SuccessCreateStoreResource;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateStoreActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $store_seed = Store::factory()->make();

        $store = [
            'login'           => $store_seed->login,
            'password_1'      => $store_seed->password_1,
            'password_2'      => $store_seed->password_2,
            'token'           => $store_seed->token,
        ];

        $request = new CreateStoreRequest($store);

        Sanctum::actingAs($user);

        $action = app(CreateStoreActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessCreateStoreResource::class, $response);
    }
}
