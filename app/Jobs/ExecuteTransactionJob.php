<?php

namespace App\Jobs;

use App\Interfaces\iTransaction;
use App\Interfaces\iUser;

use App\Core\Http\HttpClient;

use Illuminate\Support\Facades\Queue;

use App\Jobs\NotificationJob;

class ExecuteTransactionJob extends Job
{
    private $transaction_id;

    private $transaction;
    private $user;
    private $http;

    public function __construct(int $transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(iTransaction $iTransaction, iUser $iUser, HttpClient $httpClient)
    {
        $this->transaction  = $iTransaction;
        $this->user         = $iUser;
        $this->http         = $httpClient;

        $this->execute();
    }

    private function execute()
    {

        $transaction = $this->transaction->find($this->transaction_id);

        if($transaction){
            $authorization = $this->http->post(env('MOCKY_AUTORIZER'), []);
            if($authorization->getStatusCode() == 200){
                if($this->user->increaseBalance($transaction->payee, $transaction->value)){
                    $this->transaction->modifyStatus($this->transaction_id, 'processed');
                    $value = number_format($transaction->value, 2, ',', '.');
                    Queue::pushOn('high', new NotificationJob($transaction->payee, "Valor de R$ ${value} recebido com sucesso."));
                }
            }else{
                if($this->user->increaseBalance($transaction->payer, $transaction->value)){
                    $this->transaction->modifyStatus($this->transaction_id, 'not authorized');
                }   
            }
        }
        
    }

}
