<?php

namespace Tests\Feature\Track;


use App\Contracts\Actions\Track\CreateTracksActionContract;
use App\Http\Requests\Track\CreateTrackRequest;
use App\Http\Resources\Track\Create\ErrorCreateResource;
use App\Http\Resources\Track\Create\SuccessCreateResource;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;


class CreateTracksActionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * A basic feature test example.
     */
    public function test_action_error(): void
    {
        $tracks = [
            Track::factory()->make()
        ];

        $request = new CreateTrackRequest($tracks);

        $action = app(CreateTracksActionContract::class);
        $response = $action($request);


        $this->assertInstanceOf(ErrorCreateResource::class, $response);
    }

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $track_seed = Track::factory()->make();

        $tracks = [
            'name'          => $track_seed->name,
            'address'       => $track_seed->address,
            'latitude'      => fake()->latitude,
            'longitude'     => fake()->longitude,
            'levelId'       => $track_seed->level_id,
            'is_work'       => $track_seed->is_work ? 1 : 0,
        ];
        $request = new CreateTrackRequest($tracks);
        Sanctum::actingAs($user);

        $action = app(CreateTracksActionContract::class);
        $response = $action($request);
        $this->assertInstanceOf(SuccessCreateResource::class, $response);
    }
    public function test_action_success_with_file(): void
    {
        $user = User::factory()->create();
        $track_seed = Track::factory()->make();

        $file = UploadedFile::fake()->create('document.png');

        $tracks = [
            'name'          => $track_seed->name,
            'address'       => $track_seed->address,
            'latitude'      => fake()->latitude,
            'longitude'     => fake()->longitude,
            'levelId'       => $track_seed->level_id,
            'is_work'       => $track_seed->is_work ? 1 : 0,
            'images'        => [$file],
        ];
        $request = new CreateTrackRequest($tracks);
        Sanctum::actingAs($user);

        $action = app(CreateTracksActionContract::class);
        $response = $action($request);
        $this->assertInstanceOf(SuccessCreateResource::class, $response);
    }

}
