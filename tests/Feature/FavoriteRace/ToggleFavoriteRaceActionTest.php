<?php

namespace Tests\Feature\FavoriteRace;

use App\Contracts\Actions\Controllers\FavoriteUser\ToggleFavoriteRaceActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\FavoriteUser\Toggle\SuccessTogglrUserFavoriteResource;
use App\Models\FavoriteUser;
use App\Models\Race;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class ToggleFavoriteRaceActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $action = app(ToggleFavoriteRaceActionContract::class);
        $response = $action(-1);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $race = Race::factory()->create();
        Sanctum::actingAs($user);

        $action = app(ToggleFavoriteRaceActionContract::class);
        $response = $action($race->id);

        // Проверяем ответ
        $this->assertInstanceOf(SuccessTogglrUserFavoriteResource::class, $response);
    }

    public function test_action_success_delete(): void
    {
        $user = User::factory()->create();
        $race = Race::factory()->create();

        // Сначала добавляем в избранное
        FavoriteUser::create([
            'user_id' => $user->id,
            'race_id' => $race->id
        ]);

        Sanctum::actingAs($user);

        $action = app(ToggleFavoriteRaceActionContract::class);
        $response = $action($race->id);

        // Проверяем ответ
        $this->assertInstanceOf(SuccessTogglrUserFavoriteResource::class, $response);
    }
}
