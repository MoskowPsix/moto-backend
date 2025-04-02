<?php

namespace Tests\Feature\VerificationEmail;

use App\Contracts\Actions\Controllers\VerificationEmail\SendActionContract;
use App\Http\Resources\Errors\TimeOutWarningResource;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Send\SuccessSendVerificationEmailResource;
use App\Models\ECode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SendActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_already_send(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $ecode = Ecode::factory()->create([
            'user_id' => $user->id,
            'created_at' => now(),
        ]);

        Sanctum::actingAs($user);

        $action = app(SendActionContract::class);
        $response = $action();
        $this->assertInstanceOf(AlreadySendVerificationEmailResource::class, $response);
    }

    public function test_action_time_out(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $ecode = Ecode::factory()->create([
            'user_id' => $user->id,
            'created_at' => now(),
        ]);

        Sanctum::actingAs($user);

        $action = app(SendActionContract::class);
        $response = $action();
        $this->assertInstanceOf(TimeOutWarningResource::class, $response);
    }

    public function test_action_success(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $ecode = Ecode::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()->subMinutes(60),
        ]);

        Sanctum::actingAs($user);

        $action = app(SendActionContract::class);
        $response = $action();
        $this->assertInstanceOf(SuccessSendVerificationEmailResource::class, $response);
    }
}
