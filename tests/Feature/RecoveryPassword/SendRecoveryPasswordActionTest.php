<?php

namespace Tests\Feature\RecoveryPassword;

use App\Contracts\Actions\Controllers\RecoveryPassword\SendRecoveryPasswordActionContract;
use App\Http\Requests\RecoveryPassword\SendRequest;
use App\Http\Resources\RecoveryPassword\Send\SuccessSendRecoveryPasswordResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendRecoveryPasswordActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);
        Notification::fake();

        $request = new SendRequest([
            'email' => 'test@example.com',
            'url' => 'http://example.com/reset-password',
        ]);

        $action = app(SendRecoveryPasswordActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessSendRecoveryPasswordResource::class, $response);
    }
}
