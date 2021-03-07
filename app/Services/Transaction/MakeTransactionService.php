<?php

namespace App\Services\Transaction;

// use App\Core\Http\HttpClient;
use Exception;

use Illuminate\Http\JsonResponse;

use App\Interfaces\iTransaction;
use App\Interfaces\iUser;

class MakeTransactionService
{
    // private $http;
    private $transaction;
    private $user;

    public function __construct(iTransaction $iTransaction, iUser $iUser)
    {
        // $this->http = $httpClient;
        $this->transaction = $iTransaction;
        $this->user = $iUser;
    }

    public function make(array $transaction): JsonResponse
    {
        try {
            $this->transaction->create($transaction);
            $this->user->withdrawBalance($transaction['payer'], $transaction['value']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'internal error when processing the request.'
            ], 500);
        }

        return response()->json([
            'message' => 'the transaction is in process.'
        ], 201);
    }
}