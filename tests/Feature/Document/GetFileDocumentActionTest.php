<?php

namespace Tests\Feature\Document;

use App\Contracts\Actions\Controllers\Document\GetFileDocumentActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetFileDocumentActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $filePath = 'documents/test.pdf';
        Storage::disk('local')->put($filePath, 'Test content');

        $document = Document::factory()->create([
            'user_id' => $user->id,
            'path' => $filePath
        ]);

        $action = app(GetFileDocumentActionContract::class);
        $response = $action($document->id);
        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\BinaryFileResponse::class, $response);
    }

    public function test_action_not_found(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $filePath = 'documents/test.pdf';
        Storage::disk('local')->put($filePath, 'Test content');

        $document = Document::factory()->create([
            'user_id' => $user->id,
            'path' => $filePath
        ]);

        $action = app(GetFileDocumentActionContract::class);
        $response = $action(-1);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

    public function test_action_not_user_permission(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $userSecond = User::factory()->create();
        Sanctum::actingAs($userSecond);

        $filePath = 'documents/test.pdf';
        Storage::disk('local')->put($filePath, 'Test content');

        $document = Document::factory()->create([
            'user_id' => $user->id,
            'path' => $filePath
        ]);

        $action = app(GetFileDocumentActionContract::class);
        $response = $action($document->id);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
}
