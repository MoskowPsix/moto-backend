<?php

namespace Tests\Feature\VerificationEmail;

use App\Contracts\Actions\Controllers\VerificationEmail\SendActionContract;
use App\Contracts\Actions\Controllers\VerificationEmail\VerificationActionContract;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Verification\NoCorrectVerificationEmailResource;
use App\Http\Resources\verificationEmail\Verification\SuccessVerificationEmailResource;
use App\Models\ECode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VerificationActionTest extends TestCase
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
    public function test_action_no_correct(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $ecode = Ecode::factory()->create([
            'user_id' => $user->id,
            'created_at' => now(),
        ]);

        Sanctum::actingAs($user);

        $request = new EmailVerificationRequest();
        $action = app(VerificationActionContract::class);
        $response = $action($request);
        $this->assertInstanceOf(SuccessVerificationEmailResource ::class, $response);
    }
    public function test_action_no_correct_hour(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $ecode = Ecode::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()->subMinutes(61),
        ]);

        Sanctum::actingAs($user);

        $request = new EmailVerificationRequest();
        $action = app(VerificationActionContract::class);
        $response = $action($request);
        $this->assertInstanceOf(NoCorrectVerificationEmailResource::class, $response);
    }
    public function test_successful_verification()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $code = 123456;
        $ecode = Ecode::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()->subMinutes(30),
            'code' => $code,
        ]);

        Sanctum::actingAs($user);

        $request = new EmailVerificationRequest(['code' => $code]);
        $action = app(VerificationActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessVerificationEmailResource::class, $response);
    }
}
