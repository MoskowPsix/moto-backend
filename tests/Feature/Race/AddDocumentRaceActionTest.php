<?php

namespace Tests\Feature\Race;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Race\AddDocumentRaceActionContract;
use App\Http\Requests\Race\AddDocumentsRaceRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\AddDocument\SuccessAddDocumentRaceResource;
use App\Models\Race;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AddDocumentRaceActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_found_race(): void
    {
        $race = Race::factory()->create();
        $request = new AddDocumentsRaceRequest();
        $action = app(AddDocumentRaceActionContract::class);
        $response = $action(-1, $request);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
    public function test_action_not_user_permission(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->assignRole(RoleConstant::RIDER);
        $race = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $request = new AddDocumentsRaceRequest();
        $action = app(AddDocumentRaceActionContract::class);
        $response = $action($race->id, $request);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
    public function test_action_success_empty(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->assignRole(RoleConstant::COMMISSION);
        $race = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $request = new AddDocumentsRaceRequest();
        $action = app(AddDocumentRaceActionContract::class);
        $response = $action($race->id, $request);
        $this->assertInstanceOf(SuccessAddDocumentRaceResource::class, $response);
    }
    public function test_action_success_with_pdf_files(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->assignRole(RoleConstant::COMMISSION);
        $raceSeed = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $file = UploadedFile::fake()->create('file.pdf');
        $race = [
            'pdfFiles' => [$file]
        ];

        $request = new AddDocumentsRaceRequest($race);
        $action = app(AddDocumentRaceActionContract::class);
        $response = $action($raceSeed->id, $request);
        $this->assertInstanceOf(SuccessAddDocumentRaceResource::class, $response);
    }
    public function test_action_success_with_pdf_files_del(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->assignRole(RoleConstant::COMMISSION);
        $raceSeed = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $file = UploadedFile::fake()->create('file.pdf');
        $race = [
            'pdfFiles' => [$file],
            'pdfFilesDel' => [$file],
        ];

        $request = new AddDocumentsRaceRequest($race);
        $action = app(AddDocumentRaceActionContract::class);
        $response = $action($raceSeed->id, $request);
        $this->assertInstanceOf(SuccessAddDocumentRaceResource::class, $response);
    }
}
