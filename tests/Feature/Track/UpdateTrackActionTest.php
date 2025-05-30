<?php

namespace Tests\Feature\Track;

use App\Contracts\Actions\Controllers\Track\UpdateTrackActionContract;
use App\Http\Requests\Track\UpdateTrackRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Grade\Update\SuccessUpdateGradeResource;
use App\Http\Resources\Track\Update\SuccessUpdateTrackResource;
use App\Models\Level;
use App\Models\Location;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTrackActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $track = Track::factory()->create();

        $trackRequest = new UpdateTrackRequest([
            'name' => $track->name,
            'address' => $track->address,
            'latitude' => 55.751244,
            'longitude' => 37.618423,
            'is_work' => true,
            'levelId' => 1,
            'locationId' => 1,
        ]);
        $action = app(UpdateTrackActionContract::class);
        $response = $action(-1, $trackRequest);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

    public function test_action_not_permission(): void
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $trackSeed = Track::factory()->create([
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs($secondUser);
        $track = Track::factory()->create();

        $trackRequest = new UpdateTrackRequest([
            'name' => $track->name,
            'address' => $track->address,
            'latitude' => 55.751244,
            'longitude' => 37.618423,
            'is_work' => true,
            'levelId' => 1,
            'locationId' => 1,
        ]);
        $action = app(UpdateTrackActionContract::class);
        $response = $action($trackSeed->id, $trackRequest);
        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }

    public function test_action_success_with_add_images(): void
    {
        $user = User::factory()->create();
        $trackSeed = Track::factory()->create([
            'user_id' => $user->id,
        ]);

        $image = UploadedFile::fake()->create('file.png');

        $track = [
            'name'          => $trackSeed->name,
            'address'       => $trackSeed->address,
            'latitude'      => fake()->latitude,
            'longitude'     => fake()->longitude,
            'levelId'       => $trackSeed->level_id,
            'is_work'       => $trackSeed->is_work ? 1 : 0,
            'userId'        => $user->id,
            'imagesAdd'     => [$image],
        ];
        Sanctum::actingAs($user);
        $request = new UpdateTrackRequest($track);
        $action = app(UpdateTrackActionContract::class);
        $response = $action($trackSeed->id, $request);
        $this->assertInstanceOf(SuccessUpdateTrackResource::class, $response);
    }
    public function test_action_success_with_add_image(): void
    {
        $user = User::factory()->create();
        $trackSeed = Track::factory()->create([
            'user_id' => $user->id,
        ]);

        $image = UploadedFile::fake()->create('file.png');

        $track = [
            'name'          => $trackSeed->name,
            'address'       => $trackSeed->address,
            'latitude'      => fake()->latitude,
            'longitude'     => fake()->longitude,
            'levelId'       => $trackSeed->level_id,
            'is_work'       => $trackSeed->is_work ? 1 : 0,
            'userId'        => $user->id,
            'logo'          => $image,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateTrackRequest($track);
        $action = app(UpdateTrackActionContract::class);
        $response = $action($trackSeed->id, $request);
        $this->assertInstanceOf(SuccessUpdateTrackResource::class, $response);
    }
    public function test_action_success_with_del_image(): void
    {
        $user = User::factory()->create();
        $trackSeed = Track::factory()->create([
            'user_id' => $user->id,
        ]);

        $image = UploadedFile::fake()->create('file.png');

        $track = [
            'name'          => $trackSeed->name,
            'address'       => $trackSeed->address,
            'latitude'      => fake()->latitude,
            'longitude'     => fake()->longitude,
            'levelId'       => $trackSeed->level_id,
            'is_work'       => $trackSeed->is_work ? 1 : 0,
            'userId'        => $user->id,
            'imagesDel'     => [$image],
            'imagesDel.*'   => $image,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateTrackRequest($track);
        $action = app(UpdateTrackActionContract::class);
        $response = $action($trackSeed->id, $request);
        $this->assertInstanceOf(SuccessUpdateTrackResource::class, $response);
    }
}
