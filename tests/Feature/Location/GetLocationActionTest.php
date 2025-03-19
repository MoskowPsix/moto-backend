<?php

namespace Tests\Feature\Location;

use App\Contracts\Actions\Controllers\Location\GetLocationActionContract;
use App\Http\Requests\Location\GetLocationRequest;
use App\Http\Resources\Location\LocationResource\SuccessGetLocationResource;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetLocationActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $request = new GetLocationRequest([
            'paginate'  => 1,
        ]);
        $action = app(GetLocationActionContract::class);
        $response = $action($request);
        $this->assertInstanceOf(SuccessGetLocationResource::class, $response);
    }
}
