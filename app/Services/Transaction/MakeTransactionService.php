<?php

namespace App\Services\Transaction;

use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Queue;

use App\Interfaces\iTransaction;
use App\Interfaces\iUser;

use App\Jobs\ExecuteTransactionJob;

class MakeTransactionService
{
    private $transaction;
    private $user;

    public function __construct(iTransaction $iTransaction, iUser $iUser)
    {
        $this->transaction = $iTransaction;
        $this->user = $iUser;
    }

    public function make(array $transaction): JsonResponse
    {
        try {
            $transaction_id = $this->transaction->create($transaction)->id;
            $this->user->withdrawBalance($transaction['payer'], $transaction['value']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'internal error when processing the request.'
            ], 500);
        }

        Queue::laterOn('high', 10, new ExecuteTransactionJob($transaction_id));

        return response()->json([
            'message' => 'the transaction is in process.'
        ], 201);
    }
}