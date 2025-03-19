<?php

namespace Tests\Feature\Document;

use App\Contracts\Actions\Controllers\Document\GetDocumentForUserActionContract;
use App\Http\Requests\Document\GetDocumentForUserRequest;
use App\Http\Resources\Document\GetForUser\SuccessGetDocumentForUserResource;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetDocumentForUserActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $request = new GetDocumentForUserRequest();
        $action = app(GetDocumentForUserActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessGetDocumentForUserResource::class, $response);
    }
}
