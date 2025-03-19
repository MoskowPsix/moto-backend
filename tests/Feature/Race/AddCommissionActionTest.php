<?php

namespace Tests\Feature\Race;

use App\Contracts\Actions\Controllers\Race\AddCommissionActionContract;
use App\Http\Requests\Race\AddCommissionRequest;
use App\Http\Resources\User\AddCommission\SuccessAddCommissionResource;
use App\Models\Race;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddCommissionActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {

    }
}
