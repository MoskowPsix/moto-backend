<?php

namespace Tests\Feature\Document;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteDocumentActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $document = Document::factory()->create([
            'user_id' => $user->id,
        ]);

    }
}
