<?php

namespace Tests\Feature\Document;

use App\Contracts\Actions\Controllers\Document\CreateDocumentActionContract;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Resources\Document\Create\SuccessCreateDocumentResource;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateDocumentActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        Sanctum::actingAs($user);


        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $documentSeeder = Document::factory()->make();
        $document = [
            'name'          => $documentSeeder->name,
            'type'          => $documentSeeder->type,
            'path'          => $documentSeeder->path,
            'user_id'       => $user->id,
        ];
        $request = new Request(array_merge($document, ['file' => $file]));
        $createDocumentRequest = CreateDocumentRequest::createFrom($request);
        $createDocumentRequest->files->add(['file' => $file]);

        $action = app(CreateDocumentActionContract::class);
        $response = $action($createDocumentRequest);

        $this->assertInstanceOf(SuccessCreateDocumentResource::class, $response);
    }
}
