<?php

namespace App\Interfaces;

interface iTransaction 
{
    public function find(int $id);
    public function create(array $transaction);
}