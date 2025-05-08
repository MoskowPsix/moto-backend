<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Transaction\CreateTransactionActionContract;
use App\Contracts\Actions\Controllers\Transaction\FailedTransactionActionContract;
use App\Contracts\Actions\Controllers\Transaction\GetTransactionForIdActionContract;
use App\Contracts\Actions\Controllers\Transaction\GetUserTransactionsActionContract;
use App\Contracts\Actions\Controllers\Transaction\ResultTransactionActionContract;
use App\Contracts\Actions\Controllers\Transaction\SuccessTransactionActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Http\Requests\Transaction\FailedTransactionRequest;
use App\Http\Requests\Transaction\ResultTransactionRequest;
use App\Http\Requests\Transaction\SuccessTransactionRequest;
use App\Http\Requests\User\GetUserTransactionsRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Transaction\Create\SuccessCreateTransactionResource;
use App\Http\Resources\Transaction\FailedTransaction\FailedTransactionResource;
use App\Http\Resources\Transaction\GetForId\SuccessGetTransactionForIdResource;
use App\Http\Resources\Transaction\GetTransactions\SuccessGetUserTransactionsResource;
use App\Http\Resources\Transaction\SuccessTransaction\SuccessTransactionResource;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Log;

class TransactionController extends Controller
{
    #[ResponseFromApiResource(SuccessCreateTransactionResource::class, Transaction::class, collection: false)]
    #[Endpoint(title: 'create', description: 'Создание транзакции')]
    public function create(CreateTransactionRequest $request, CreateTransactionActionContract $action): SuccessCreateTransactionResource
    {
        return $action($request);
    }

    #[ResponseFromApiResource(TransactionResource::class, Transaction::class, collection: false)]
    #[Endpoint(title: 'result', description: 'Получение ответа')]
    public function result(Request $request, ResultTransactionActionContract $action)
    {
        Log::info('Robokassa ResultUrl request:', $request->all());
        return $action($request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessGetUserTransactionsResource::class, Transaction::class)]
    #[Endpoint(title: 'getTransactions', description: 'Получить все транзакции пользователя.')]
    public function getTransactions(GetUserTransactionsRequest $request, GetUserTransactionsActionContract $action): SuccessGetUserTransactionsResource
    {
        return $action($request);
    }
    public function getTransactionForId(int $id, GetTransactionForIdActionContract $action):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessGetTransactionForIdResource
    {
        return $action($id);
    }
}
