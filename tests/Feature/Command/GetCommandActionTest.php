<?php

namespace Tests\Feature\Command;

use App\Actions\Controllers\Command\GetCommandAction;
use App\Contracts\Actions\Controllers\Command\GetCommandActionContract;
use App\Http\Requests\Command\GetCommandRequest;
use App\Http\Resources\Command\GetCommand\SuccessGetCommandResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCommandActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;


    public function test_action_success(): void
    {
        $getCommand = new GetCommandRequest();
        $action = app(GetCommandActionContract::class);

        $response = $action($getCommand);
        $this->assertInstanceOf(SuccessGetCommandResource::class, $response);
    }

    public function test_action_success_with_paginate(): void
    {
        $getCommand = new GetCommandRequest([
            'paginate'  => 1,
            'page'      => 1,
            'limit'     => 10,
        ]);
        $action = app(GetCommandActionContract::class);

        $response = $action($getCommand);
        $this->assertInstanceOf(SuccessGetCommandResource::class, $response);
    }
}
