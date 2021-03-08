<?php

namespace App\Repositories;

use App\Interfaces\iTransaction;

use App\Models\Transaction;

class TransactionRepository implements iTransaction
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        return $this->transaction = $transaction;
    }

    public function find(int $id): Transaction
    {
        return $this->transaction->find($id);
    }

    public function create(array $transaction): Transaction
    {
        return $this->transaction->create($transaction);
    }
    
}