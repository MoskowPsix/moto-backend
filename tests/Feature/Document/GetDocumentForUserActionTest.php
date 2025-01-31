<?php

namespace Tests\Feature\Document;

use App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetDocumentForUserActionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_action_success(): void
    {
        $document = Document::factory()->create();
    }
}
