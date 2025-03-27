<?php

namespace Tests\Feature\Command;

use App\Contracts\Actions\Controllers\Command\GetMembersActionContract;
use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetMember\SuccessGetMemberCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetMembersActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $command = Command::factory()->create();
        $request = new GetCouchesCommandRequest();
        $action = app(GetMembersActionContract::class);
        $response = $action($command->id, $request);
        $this->assertInstanceOf(SuccessGetMemberCommandResource::class, $response);
    }

    public function test_action_success_with_paginate(): void
    {
        $command = Command::factory()->create();
        $request = new GetCouchesCommandRequest([
            'paginate'  => 1,
            'page'      => 1,
            'limit'     => 10,
        ]);
        $action = app(GetMembersActionContract::class);
        $response = $action($command->id, $request);
        $this->assertInstanceOf(SuccessGetMemberCommandResource::class, $response);
    }

    public function test_action_not_found(): void
    {
        $command = Command::factory()->create();
        $request = new GetCouchesCommandRequest([
            'paginate'  => 1,
            'page'      => 1,
            'limit'     => 10,
        ]);
        $action = app(GetMembersActionContract::class);
        $response = $action(-1, $request);
        $this->assertInstanceOf(NotFoundResource::class, $response);
    }
}
