<?php

namespace Tests\Feature\Document;

use App\Contracts\Actions\Controllers\Document\CreateDocumentActionContract;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Resources\Document\Create\SuccessCreateDocumentResource;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateDocumentActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $documentSeeder = Document::factory()->make();
        $document = [
            'name'          => $documentSeeder->name,
            'type'          => $documentSeeder->type,
            'path'          => $documentSeeder->path,
            'user_id'       => $user->id,
        ];
        $request = new CreateDocumentRequest($document);
        $action = app(CreateDocumentActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessCreateDocumentResource::class, $response);
    }
}
