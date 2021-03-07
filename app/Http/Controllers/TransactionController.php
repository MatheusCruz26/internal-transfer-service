<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Http\Requests\TransactionRequest;

use App\Services\Transaction\MakeTransactionService;

class TransactionController extends Controller
{
    private $service;

    public function __construct(MakeTransactionService $makeTransactionService)
    {
        $this->service = $makeTransactionService;
    }

    public function store(TransactionRequest $request): JsonResponse 
    {
        return $this->service->make(
            [
                'value' => $request->value,
                'payer' => $request->payer,
                'payee' => $request->payee
            ]
        );
    }
}
