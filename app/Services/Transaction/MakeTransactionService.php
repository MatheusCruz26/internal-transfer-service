<?php

namespace App\Services\Transaction;

use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Queue;

use App\Interfaces\iTransaction;
use App\Interfaces\iUser;

use App\Jobs\NotificationJob;

use App\Core\Http\HttpClient;

class MakeTransactionService
{
    private $transaction;
    private $user;
    private $http;

    public function __construct(iTransaction $iTransaction, iUser $iUser, HttpClient $httpClient)
    {
        $this->transaction = $iTransaction;
        $this->user = $iUser;
        $this->http = $httpClient;
    }

    public function make(array $transaction): JsonResponse
    {
        try {
            $authorization = $this->http->post(env('MOCKY_AUTORIZER'), []);
        
            if($authorization->getStatusCode() == 200){
                $this->user->withdrawBalance($transaction['payer'], $transaction['value']);
                $this->user->increaseBalance($transaction['payee'], $transaction['value']);
            }else{
                return response()->json([
                    'message' => 'the transaction was not authorized.'
                ], 400);
            }

            $this->transaction->create($transaction);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'internal error when processing the request.'
            ], 500);
        }

        $value = number_format($transaction['value'], 2, ',', '.');

        Queue::pushOn('high', new NotificationJob($transaction['payee'], "Olá, você acabou de receber uma nova transferência no valor de R$ ${value}."));

        return response()->json([
            'message' => 'the transaction was successful.'
        ], 200);
    }
}