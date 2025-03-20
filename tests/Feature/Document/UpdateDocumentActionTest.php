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
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateDocumentActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
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

    public function test_action_not_user_permission(): void
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
