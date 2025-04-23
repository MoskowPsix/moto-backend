<?php

namespace Tests\Feature\Document;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Document\VerifyDocsForCommissionActionContract;
use App\Http\Requests\Document\VerifyDocsForCommissionDocumentRequest;
use App\Http\Resources\Document\VerifyDocsForCommission\SuccessVerifyDocsForCommissionResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VerifyDocsForCommissionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_success(): void
    {
        $user_commission = User::factory()->create();
        $user_rider = User::factory()->create();

        $user_commission->assignRole(RoleConstant::COMMISSION);

        $document = Document::factory()->create([
            'user_id' => $user_rider->id
        ]);
        $request = new Request([
            'comment' => fake()->text(),
            'checked' => 0
        ]);
        $createDocumentRequest = VerifyDocsForCommissionDocumentRequest::createFrom($request);

        Sanctum::actingAs($user_commission);

        $action = app(VerifyDocsForCommissionActionContract::class);
        $response = $action($document->id, $createDocumentRequest);

        $this->assertInstanceOf(SuccessVerifyDocsForCommissionResource::class, $response);
    }

    public function test_not_fount()
    {
        $user_commission = User::factory()->create();

        $user_commission->assignRole(RoleConstant::COMMISSION);

        $request = new Request([
            'comment' => fake()->text(),
            'checked' => 0
        ]);
        $createDocumentRequest = VerifyDocsForCommissionDocumentRequest::createFrom($request);

        Sanctum::actingAs($user_commission);

        $action = app(VerifyDocsForCommissionActionContract::class);
        $response = $action(fake()->biasedNumberBetween(1,100), $createDocumentRequest);

        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
}
