<?php

namespace App\Http\Controllers\Api;

use App\Actions\Controllers\Transaction\GetTransactionForIdAction;
use App\Contracts\Actions\Controllers\Transaction\CreateTransactionActionContract;
use App\Contracts\Actions\Controllers\Transaction\GetTransactionForIdActionContract;
use App\Contracts\Actions\Controllers\Transaction\GetUserTransactionsActionContract;
use App\Contracts\Actions\Controllers\Transaction\ResultTransactionActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Http\Requests\Transaction\ResultTransactionRequest;
use App\Http\Requests\User\GetUserTransactionsRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Transaction\Create\SuccessCreateTransactionResource;
use App\Http\Resources\Transaction\GetForId\SuccessGetTransactionForIdResource;
use App\Http\Resources\Transaction\GetTransactions\SuccessGetUserTransactionsResource;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        return $action($request);
    }
    #[ResponseFromApiResource(SuccessGetUserTransactionsResource::class, Transaction::class, collection: true)]
    #[Endpoint(title: 'get', description: 'Получение трасс по фильтрам')]
    public function getTransactions(GetUserTransactionsRequest $request, GetUserTransactionsActionContract $actionGetTrack): SuccessGetUserTransactionsResource
    {
        return $actionGetTrack($request);
    }
    #[ResponseFromApiResource(SuccessGetTransactionForIdResource::class, Transaction::class, collection: false)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'create', description: 'Создание транзакции')]
    public function getTransactionForId(int $id, GetTransactionForIdActionContract $action): SuccessGetTransactionForIdResource | NotFoundResource
    {
        return $action($id);
    }
}
