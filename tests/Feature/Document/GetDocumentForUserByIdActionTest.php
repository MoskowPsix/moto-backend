<?php

namespace Tests\Feature\Document;

use App\Contracts\Actions\Controllers\Document\GetDocumentForUserActionContract;
use App\Contracts\Actions\Controllers\Document\GetDocumentForUserByIdActionContract;
use App\Http\Requests\Document\GetDocumentForUserRequest;
use App\Http\Resources\Document\GetForUser\SuccessGetDocumentForUserResource;
use App\Http\Resources\Document\GetForUserById\NotFoundGetDocumentForUserByIdResource;
use App\Http\Resources\Document\GetForUserById\SuccessGetDocumentForUserByIdResource;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetDocumentForUserByIdActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $document = Document::factory()->create([
            'user_id' => $user->id,
        ]);
        Sanctum::actingAs($user);

        $action = app(GetDocumentForUserByIdActionContract::class);
        $response = $action($document->id);

        $this->assertInstanceOf(SuccessGetDocumentForUserByIdResource::class, $response);
    }

    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        $document = Document::factory()->create([
            'user_id' => $user->id,
        ]);
        Sanctum::actingAs($user);

        $action = app(GetDocumentForUserByIdActionContract::class);
        $response = $action(-1);

        $this->assertInstanceOf(NotFoundGetDocumentForUserByIdResource::class, $response);
    }
}
