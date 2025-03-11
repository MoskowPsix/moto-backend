<?php

namespace Tests\Feature\Attendance;

use App\Contracts\Actions\Controllers\Attendance\GetForIdAttendanceActionContract;
use App\Http\Requests\Attendance\GetForIdAttendanceRequest;
use App\Http\Resources\Attendance\GetAttendanceForId\SuccessGetAttendanceForIdResource;
use App\Models\Attendance;
use App\Models\Track;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAttendanceForIdActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_action_success(): void
    {
        $track = Track::factory()->create();
        $attendance = Attendance::factory()->create();

        $request = new GetForIdAttendanceRequest([
            'track_id' => $track->id,
        ]);

        $action = app(GetForIdAttendanceActionContract::class);
        $response = $action($attendance->id, $request);

        $this->assertInstanceOf(SuccessGetAttendanceForIdResource::class, $response);
    }
}
