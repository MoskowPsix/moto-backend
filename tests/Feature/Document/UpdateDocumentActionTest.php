<?php

namespace Tests\Feature\Document;

use App\Contracts\Actions\Controllers\Document\CreateDocumentActionContract;
use App\Contracts\Actions\Controllers\Document\UpdateDocumentActionContract;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Resources\Document\Create\SuccessCreateDocumentResource;
use App\Http\Resources\Document\Update\SuccessUpdateDocumentResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Request;
use Tests\TestCase;

class UpdateDocumentActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $document_seed = Document::factory()->create([
            'user_id' => $user->id,
        ]);

        $file = UploadedFile::fake()->create('file.png');

        $document = [
            'type'          => $document_seed->type,
            'number'        => $document_seed->number,
            'issuedWhom'    => $document_seed->issuedWhom,
            'name'          => $file,
            'it_works_date' => $document_seed->itWorksDate,
        ];

        $request = new UpdateDocumentRequest($document);
        $action = app(UpdateDocumentActionContract::class);
        $response = $action($document_seed->id, $request);

        $this->assertInstanceOf(SuccessUpdateDocumentResource::class, $response);
    }
    public function test_action_success_file(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $oldFile = 'user/documents/old_file.txt';
        Storage::put($oldFile, 'old content');

        $document_seed = Document::factory()->create([
            'user_id' => $user->id,
            'path' => $oldFile,
        ]);

        $newFile = UploadedFile::fake()->create('new_file.png');

        $requestData = [];
        $request = UpdateDocumentRequest::createFrom(new Request($requestData));
        $request->files->add(['file' => $newFile]);

        $action = app(UpdateDocumentActionContract::class);
        $response = $action($document_seed->id, $request);

        $this->assertInstanceOf(SuccessUpdateDocumentResource::class, $response);
    }
    public function test_action_success_file_null(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $document_seed = Document::factory()->create([
            'user_id' => $user->id,
            'path' => 'no-file',
        ]);

        $file = UploadedFile::fake()->create('test.pdf');

        $requestData = [];
        $request = UpdateDocumentRequest::createFrom(new Request($requestData));
        $request->files->add(['file' => $file]);

        $action = app(UpdateDocumentActionContract::class);
        $response = $action($document_seed->id, $request);

        $this->assertInstanceOf(SuccessUpdateDocumentResource::class, $response);

        $updatedDoc = Document::find($document_seed->id);
        $this->assertNotEquals('no-file', $updatedDoc->path);
    }

    public function test_action_not_found_resource(): void
    {
        $user = User::factory()->create();
        $document_seed = Document::factory()->create([
            'user_id' => $user->id,
        ]);

        $file = UploadedFile::fake()->create('file.png');

        $document = [
            'type'          => $document_seed->type,
            'number'        => $document_seed->number,
            'issuedWhom'    => $document_seed->issuedWhom,
            'name'          => $file,
            'it_works_date' => $document_seed->itWorksDate,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateDocumentRequest($document);
        $action = app(UpdateDocumentActionContract::class);
        $response = $action(-1, $request);

        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
}
