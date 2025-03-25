<?php

namespace Tests\Feature\Cup;

use App\Contracts\Actions\Controllers\Cup\CreateCupActionContract;
use App\Http\Requests\Cup\CreateCupRequest;
use App\Http\Resources\Cup\Create\SuccessCreateCupResource;
use App\Http\Resources\Cup\CupResource;
use App\Models\Cup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateCupActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $cupResource = Cup::factory()->make();
        $file = UploadedFile::fake()->create('document.png');

        $cup = [
            'name' => $cupResource->name,
            'year' => $cupResource->year,
            'stages'    => $cupResource->stages,
            'userId' => $user->id,
            'locationId' => $cupResource->location_id,
            'image'     => $file,
        ];
        Sanctum::actingAs($user);
        $resource = new CreateCupRequest($cup);
        $action = app(CreateCupActionContract::class);
        $response = $action($resource);

        $this->assertInstanceOf(SuccessCreateCupResource::class, $response);
    }
}
