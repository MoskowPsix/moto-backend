<?php

namespace Tests\Feature\Race;

use App\Contracts\Actions\Controllers\Race\UpdateRaceActionContract;
use App\Http\Requests\Race\UpdateRaceRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\Update\SuccessUpdateRaceResource;
use App\Models\Race;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateRaceActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $track = Track::factory()->create();
        $raceSeed  = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $race = [
            'name' => $raceSeed->name,
            'desc' => $raceSeed->desc,
            'date_start' => $raceSeed->date_start,
            'trackId' => $track->id,
            'locationId' => $track->location_id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateRaceRequest($race);
        $action = app(UpdateRaceActionContract::class);
        $response = $action($raceSeed->id, $request);
        $this->assertInstanceOf(SuccessUpdateRaceResource::class, $response);
    }

    public function test_action_not_permission(): void
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $track = Track::factory()->create();
        $raceSeed  = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $race = [
            'name' => $raceSeed->name,
            'desc' => $raceSeed->desc,
            'date_start' => $raceSeed->date_start,
            'trackId' => $track->id,
            'locationId' => $track->location_id,
        ];
        Sanctum::actingAs($secondUser);
        $request = new UpdateRaceRequest($race);
        $action = app(UpdateRaceActionContract::class);
        $response = $action($raceSeed->id, $request);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }

    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        $track = Track::factory()->create();
        $raceSeed  = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $race = [
            'name' => $raceSeed->name,
            'desc' => $raceSeed->desc,
            'date_start' => $raceSeed->date_start,
            'trackId' => $track->id,
            'locationId' => $track->location_id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateRaceRequest($race);
        $action = app(UpdateRaceActionContract::class);
        $response = $action(-1, $request);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

    public function test_action_success_with_add_image(): void
    {
        $user = User::factory()->create();
        $track = Track::factory()->create();
        $raceSeed  = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $image = UploadedFile::fake()->create('file.png');
        $race = [
            'name' => $raceSeed->name,
            'desc' => $raceSeed->desc,
            'date_start' => $raceSeed->date_start,
            'trackId' => $track->id,
            'imagesAdd' => [$image],
            'locationId' => $track->location_id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateRaceRequest($race);
        $action = app(UpdateRaceActionContract::class);
        $response = $action($raceSeed->id, $request);
        $this->assertInstanceOf(SuccessUpdateRaceResource::class, $response);
    }
    public function test_action_success_with_delete_image(): void
    {
        $user = User::factory()->create();
        $track = Track::factory()->create();
        $raceSeed  = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $image = UploadedFile::fake()->create('file.png');
        $race = [
            'name' => $raceSeed->name,
            'desc' => $raceSeed->desc,
            'date_start' => $raceSeed->date_start,
            'trackId' => $track->id,
            'imagesDel' => [$image],
            'locationId' => $track->location_id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateRaceRequest($race);
        $action = app(UpdateRaceActionContract::class);
        $response = $action($raceSeed->id, $request);
        $this->assertInstanceOf(SuccessUpdateRaceResource::class, $response);
    }


    public function test_action_success_with_add_files(): void
    {
        $user = User::factory()->create();
        $track = Track::factory()->create();
        $raceSeed  = Race::factory()->create([
            'user_id' => $user->id,
        ]);
        $positionFile = UploadedFile::fake()->create('position.pdf');
        $resultsFile = UploadedFile::fake()->create('results.pdf');
        $race = [
            'name' => $raceSeed->name,
            'desc' => $raceSeed->desc,
            'date_start' => $raceSeed->date_start,
            'trackId' => $track->id,
            'positionFile' => $positionFile,
            'resultsFile' => $resultsFile,
            'locationId' => $track->location_id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateRaceRequest($race);
        $action = app(UpdateRaceActionContract::class);
        $response = $action($raceSeed->id, $request);
        $this->assertInstanceOf(SuccessUpdateRaceResource::class, $response);
    }
}
